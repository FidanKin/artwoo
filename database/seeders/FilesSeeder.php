<?php

namespace Database\Seeders;

use Faker\Core\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Source\Entity\User\Models\User;
use Source\Lib\FileIdentityDTO;
use Source\Lib\Text\FactoryStorageClass;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakeFileStorage = new FactoryStorageClass('user_artworks');
        foreach ($this->getAuthors() as $author) {
            $dto = new FileIdentityDTO('artwork', $author->id, 0);
            $files = $fakeFileStorage->getPathNameHashes(rand(0, 9));
            foreach ($files as $file) {
                $this->saveUserFile($dto, $file);
            }
        }
        //
    }

    private function getAuthors(): array
    {
        return User::getAuthors();
    }

    private function saveUserFile(FileIdentityDTO $DTO, \SplFileInfo $file)
    {
        return DB::table('files')->insert([
          'contenthash' => '<fakeimage>',
          'pathnamehash' => $file->getBasename(),
          'component' => $DTO->component,
          'filearea' => $DTO->filearea,
          'item_id' => $DTO->itemid,
          'filename' => $file->getClientOriginalName(),
          'filesize' => $file->getSize(),
          'mimetype' => $file->getClientMimeType(),
          'user_id' => $DTO->userid,
          'author' => null,
          'status' => $DTO->status,
          'sort_order' => 0,
        ]);
    }
}
