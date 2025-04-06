<?php

namespace Source\Lib;

use App\Exceptions\BaseFileHandlerException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Source\Event\FileNotDeleted;
use Source\Event\FileSuccessfullyDeleted;
use Source\Helper\Enums\Crud;
use Source\Lib\SavedFileDTO;
use Symfony\Component\HttpFoundation\File\File;

class FileStorage
{
    private const USER_PATH_PREFIX = 'auc_';

    /**
     * Инициализация файлового хранилища
     *
     * @param  string  $type - тип файлов, которые будут использоваться
     */
    public function __construct(private readonly string $type = 'image')
    {
        // nothing :)
    }

    /**
     * Создаем уникальный хеш файла
     * На каждый файл создается уникальный путь, т.е. мы позволяем сохранить 2 раза один и тот же файл
     */
    public function generateUniqID(File $file): string
    {
        return $this->fileContentHash($file) . uniqid();
    }

    /**
     * Создаем контентхеш файла
     *
     * @param File $file
     *
     * @return string
     */
    public function fileContentHash(File $file): string
    {
        return hash_file('md5', $file->getRealPath());
    }

    /**
     * Получить директорию файла по его уникальному ID
     *
     * @param string $fileHash - контен хеш файла
     *
     * @return string
     */
    private function getFileDirFromFileHash(string $fileHash): string
    {
        $l1 = substr($fileHash, 0, 2);
        $l2 = substr($fileHash, 2, 2);
        return "/{$l1}/{$l2}/";
    }

    /**
     * Получить полное название файла из сервера по его уникальному идентификатору пути
     *
     * @param string $fileIdPath
     *
     * @return string|false
     */
    public function getFileRealPath(string $fileIdPath): string|false
    {
        require_once base_path('source/Helper/AppLib.php');

        $record = DB::table('files')
          ->where('pathnamehash', '=', $fileIdPath)
          ->first();

        if (! empty($record)) {
            $dir = $this->getFileDirFromFileHash($record->contenthash);
            // возможно, это не идеальное решение, но нам нужно быстрое решение
            // @todo сделать более безопасное определения расширения файла
            $realpath = static::getRootPath()."{$dir}" . $record->contenthash;
            if (file_exists($realpath)) {
                return $realpath;
            }
        }

        return false;
    }

    private static function getRootPath()
    {
        return config('filesystems.disks.local.root');
    }

    /**
     * Проверяем, что файл имеет допустимое разрешение
     *
     * @throws BaseFileHandlerException
     */
    private function validateExtension(File $file): void
    {
        $allowed = $this->allowedExtensions();

        if (! in_array(!empty($file->getExtension()) ? $file->getExtension() : $file->guessExtension(), $allowed)) {
            throw new BaseFileHandlerException(['invalid_extension' => ['needle' => $allowed]],
                BaseFileHandlerException::INVALID_EXTENSION);
        }
    }

    /**
     * Проверяем, что размер файла находится в допустимом пределе
     *
     * @throws BaseFileHandlerException
     */
    private function validateFilesize(File $file): void
    {
        $maxFilesize = config('filesystems.upload.size.max_file_size');
        if ($file->getSize() >= $maxFilesize) {
            throw new BaseFileHandlerException(['file_size_limit' => ['max' => $maxFilesize]],
                BaseFileHandlerException::FILE_SIZE_LIMIT);
        }
    }

    /**
     * Возвращает список расширений файлов, которые могут быть сохранены
     */
    private function allowedExtensions(): array
    {
        return config()->has("filesystems.upload.extension.{$this->type}") ?
            config("filesystems.upload.extension.{$this->type}") : ['jpg', 'png', 'jpeg', 'webp'];
    }

    public function getAllowedExtensions(): array
    {
        return $this->allowedExtensions();
    }

    /**
     * Сохранить файла физически на сервере
     */
    private function saveIntoStorage(File $file): SavedFileDTO|false
    {
        $hashFile = $this->fileContentHash($file);

        /**
         * Если контент хеш уже существует, то не выполням попытку сохранить файл на диск
         */
        if (FileRecord::isFileExists($hashFile)) {
            return new SavedFileDTO($file, $hashFile);
        }

        $dir = $this->getFileDirFromFileHash($hashFile);
        $saved = Storage::putFileAs($dir, $file, $hashFile);

        if ($saved) {
            return new SavedFileDTO($file, $hashFile);
        }

        return false;
    }

    public function getFiles(FileIdentityDTO $fileIdentityDTO): array
    {
        $fr = new FileRecord($fileIdentityDTO);
        return $fr->get();
    }

    /**
     * получаем ссылки на файлы
     */
    public function getFilesAsUrl(FileIdentityDTO $fileIdentityDTO): array
    {
        $urls = [];
        foreach ($this->getFiles($fileIdentityDTO) as $file) {
            $urls[] = url("/filesmanager/{$file->pathnamehash}");
        }

        return $urls;
    }

    /**
     * Выполнить сохранение нескольких файлов
     *
     * @param File[] $files
     * @param FileIdentityDTO $fileIdentityDTO
     * @return void
     * @throws BaseFileHandlerException
     */
    public function saveMany(array $files, FileIdentityDTO $fileIdentityDTO): void
    {
        $this->validation($files);

        foreach ($files as $file) {
            $contenthash = $this->fileContentHash($file);

            DB::transaction(function() use($fileIdentityDTO, $file) {
                $fr = new FileRecord($fileIdentityDTO);

                if(! $saved = $this->saveIntoStorage($file)) {
                    Log::warning('>>> Cannot save file {fileinfo} into filestorage',
                        ['fileinfo' => $file->__toString()]);
                    throw new BaseFileHandlerException([], BaseFileHandlerException::SAVING_ERROR);
                }
                if (! $fr->save($saved)) {
                    Log::warning('>>> Cannot save file {fileinfo} into database',
                        ['fileinfo' => $file->__toString()]);
                    throw new BaseFileHandlerException([], BaseFileHandlerException::SAVING_ERROR);
                }

            });
        }
    }

    /**
     * Выполнить сохранение одного файла
     *
     * @param File $file
     * @param FileIdentityDTO $fileIdentityDTO
     * @return void
     * @throws BaseFileHandlerException
     */
    public function saveOne(File $file, FileIdentityDTO $fileIdentityDTO): void
    {
        $this->validation([$file]);
        DB::transaction(function() use($fileIdentityDTO, $file) {
            $fr = new FileRecord($fileIdentityDTO);

            if(! $saved = $this->saveIntoStorage($file)) {
                Log::warning('>>> Cannot save file {fileinfo} into filestorage',
                    ['fileinfo' => $file->__toString()]);
                throw new BaseFileHandlerException([], BaseFileHandlerException::SAVING_ERROR);
            }
            if (! $fr->save($saved)) {
                Log::warning('>>> Cannot save file {fileinfo} into database',
                    ['fileinfo' => $file->__toString()]);
                throw new BaseFileHandlerException([], BaseFileHandlerException::SAVING_ERROR);
            }

        });

    }

    public static function setSorting(array $items): bool
    {
        return FileRecord::setOrder($items);
    }

    /**
     * Выполняем "мягкое" удаление
     */
    public function delete(FileIdentityDTO $fileIdentityDTO): int
    {
        $fr = new FileRecord($fileIdentityDTO);

        return $fr->delete();
    }

    /**
     * Помечает файл к удалению
     */
    public static function deleteByPathnamehash(string $pathnamehash): bool
    {
        return FileRecord::deleteByPathnamehash($pathnamehash);
    }

    /**
     * @throws \App\Exceptions\BaseFileHandlerException
     */
    private function validation(array $files): void
    {
        foreach ($files as $file) {
            $this->validateExtension($file);
            $this->validateFilesize($file);
        }
    }

    /**
     * Полное удаление файла из хранилища
     *
     * @todo дописать удаление файлов с проверкой по contenthash
     * @return bool
     */
    public function fullDelete(): bool
    {
        $records = FileRecord::getDeleted();
        if ($records->isEmpty()) {
            return true;
        }

        foreach ($records as $record) {
            $id = $record->id;
            $pathhash = $record->pathnamehash;
            $contenthash = $record->contenthash;

            $canDeleteFromDisk = ! FileRecord::isMoreOneFilesByContenthash($contenthash);

            if ($canDeleteFromDisk) {
                if ($path = $this->getFileRealPath($pathhash)) {
                    if (! unlink($path)) {
                        FileNotDeleted::dispatch(Crud::DELETE, $id, ['reason' => 'Cannot delete from local storage', 'pathnamehash' => $pathhash]);
                    };
                }
            }

            FileRecord::deleteById($id);
            FileSuccessfullyDeleted::dispatch(Crud::DELETE, $id, ['pathnamehash' => $pathhash]);
        }

        return true;
    }

    public static function deleteUserFiles(int $userId): bool
    {

    }
}
