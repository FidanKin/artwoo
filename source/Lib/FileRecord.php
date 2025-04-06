<?php

namespace Source\Lib;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Source\Lib\SavedFileDTO;
use Symfony\Component\HttpFoundation\File\File;

class FileRecord
{
    public const FILE_STATUS_DELETE = 'deleted';

    public const FILE_STATUS_UNVERIFIED = 'unverified';

    public function __construct(private readonly FileIdentityDTO $fileIdentity)
    {

    }

    public function save(SavedFileDTO $savedFileDTO): bool
    {
        return DB::table('files')->insert([
            'contenthash' => $savedFileDTO->contentHash,
            'pathnamehash' => $this->generatePathnameHash(),
            'component' => $this->fileIdentity->component,
            'filearea' => $this->fileIdentity->filearea,
            'item_id' => $this->fileIdentity->itemid,
            'filename' => $savedFileDTO->file->getBasename(),
            'filesize' => $savedFileDTO->file->getSize(),
            'mimetype' => $savedFileDTO->file->guessExtension(),
            'user_id' => $this->fileIdentity->userid,
            'author' => null,
            'status' => $this->fileIdentity->status,
            'sort_order' => $savedFileDTO->order,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Обновить сортировку
     *
     * @param array $items - массив в массива, обязательно первое поле должно быть pathnamehash, второе - значение сортировки
     * @return bool
     */
    public static function setOrder(array $items): bool
    {
        foreach ($items as $item) {
            if (is_array($item) && count($item) === 2 && is_scalar($item[0]) && is_scalar($item[1])) {
                DB::table('files')->where('pathnamehash', '=', $item[0])
                        ->update(['sort_order' => (int)$item[1]]);
            }
        }

        return true;
    }

    /**
     * Получение записей файлов
     */
    public function get(): array
    {
        $init = DB::table('files')->select()
            ->where('item_id', '=', $this->fileIdentity->itemid)
            ->where('component', '=', $this->fileIdentity->component)
            ->where('user_id', '=', $this->fileIdentity->userid)
            ->where('status', '!=', static::FILE_STATUS_DELETE)
            ->orderBy('sort_order', 'asc');
        if (! empty($this->fileIdentity->filearea)) {
            $init->where('filearea', '=', $this->fileIdentity->filearea);
        }

        return $init->get()->all();
    }

    /**
     * Производит "Мягкое удаление", т.е. мы помечаем записи к удалению
     * Окончательно удалены они будут по крону
     *
     * Для удаления необходимо внимательно проверять переданный ДТО
     */
    public function delete(): int
    {
        $builder = DB::table('files')
            ->where('item_id', '=', $this->fileIdentity->itemid)
            ->where('component', '=', $this->fileIdentity->component)
            ->where('user_id', '=', $this->fileIdentity->userid);

            if (! empty($this->fileIdentity->filearea)) {
                $builder->where('filearea', '=', $this->fileIdentity->filearea);
            }

            return $builder->update(['status' => static::FILE_STATUS_DELETE]);
    }

    /**
     * Создаем уникальный идентификатор файла
     */
    private function generatePathnameHash(): string
    {
        return Str::uuid()->toString();
    }

    /**
     * Помечает файл к удалению
     */
    public static function deleteByPathnamehash(string $pathnamehash): bool
    {
        return (bool) DB::table('files')->where('pathnamehash', '=', $pathnamehash)->update([
            'status' => self::FILE_STATUS_DELETE,
        ]);
    }

    public static function getDeleted(): \Illuminate\Support\Collection
    {
        return DB::table('files')->where('status', '=', static::FILE_STATUS_DELETE)->get();
    }

    /**
     * Выполнить полное удаление записей, которые помечены к удалению
     *
     * @return int
     */
    public static function deleteById(int $id): int
    {
        return DB::table('files')->where('id', '=', $id)->delete();
    }

    /**
     * Проверяем, существует ли файл с таким же контент хешом
     *
     * @param string $contenthash - контент хеш
     * @return bool
     */
    public static function isFileExists(string $contenthash): bool
    {
        return DB::table('files')->where('contenthash', '=', $contenthash)->exists();
    }

    /**
     * Проверяем, существует ли более одного файла с переданным контентхешом и что такие файлы не помечены к удалению
     *
     * @param string $contenthash
     * @return bool
     */
    public static function isMoreOneFilesByContenthash(string $contenthash): bool
    {
        return DB::table('files')->where('contenthash', '=', $contenthash)
                ->where('status', '!=', static::FILE_STATUS_DELETE)->count() > 1;
    }

    public static function canDeleteAfterUserDelete(string $contenthash, int $userId): bool
    {
        return DB::table('files')->where('contenthash', '=', $contenthash)
            ->where('status', '!=', static::FILE_STATUS_DELETE)
            ->where('user_id', '!=', $userId)->count() > 1;
    }

    public static function deleteAllUserFiles(int $userId): bool
    {
        return DB::table('files')->where('user_id', '=', $userId)->delete();
    }

    /**
     * Отметить записи с contenthash как ватермарка добавлена
     *
     * @param string $contenthash
     * @return void
     */
    public static function setWatermarked(string $contenthash): void
    {
        DB::table('files')->where('contenthash', '=', $contenthash)->update(['watermarked' => true]);
    }
}
