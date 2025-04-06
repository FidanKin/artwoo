<?php

namespace Source\Lib;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

//
class FactoryStorageClass
{
    private Filesystem $storage;
    private array $files = [];
    public function __construct(private readonly string $dir)
    {
        $this->initStorage();
    }

    /**
     * Получить полный путь к файлу по его пути хеша - это просто название файла в директории
     * @param string $pathnamehash
     *
     * @return string|false
     */
    public function getFileRealPathByHash(string $pathnamehash): string|false
    {
//        if (file_exists($this->storage . $pathnamehash)) {
//            return $this->storage . $pathnamehash;
//        }
//
//        return false;
    }

    private function initStorage(): void
    {
        $this->storage = Storage::build(['driver' => 'local', 'root' => $this->storagePath()]);
        $this->files = $this->storage->files();
    }

    private function storagePath(): string
    {
        return storage_path('app/dump/' . $this->normalizeDir($this->dir));
    }

    public function getFiles(bool $asFileObject = true): array
    {
        $this->files = $this->storage->files();
        if (! $asFileObject) {
            return $this->files;
        }

        $files = [];
        foreach ($this->files as $file) {
            $files[] = new File($this->storagePath() . $file);
        }
        shuffle($files);

        return $files;
    }

    /**
     * Выдать уникальный код изображения - его название у указанного количества изображений
     * @param int $quantity
     *
     * @return array<string>
     */
    public function getPathNameHashes(int $quantity): array
    {
        $rand = array_rand($this->files, $quantity);
        if ($quantity === 1) {
            return [$this->files[$rand]];
        }

        $result = [];
        foreach ($rand as $index) {
            $result[] = $this->files[$index];
        }
        return $result;
    }

    private function normalizeDir(string $dir): string
    {
        return trim($dir, '/') . '/';
    }

}
