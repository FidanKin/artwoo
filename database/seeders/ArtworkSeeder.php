<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Source\Entity\Artwork\Models\Artwork;
use Source\Entity\User\Models\User;
use Source\Lib\FactoryStorageClass;

class ArtworkSeeder extends Seeder
{
    private FactoryStorageClass $factoryFileStorage;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getAuthors() as $author) {
            $this->createArtworksForUser($author, rand(4, 10));
        }
    }

    private function getAuthors(): array
    {
        return User::getAuthors();
    }

    /**
     * Авторская работа пустышка
     *
     * @param int $userId
     *
     * @return array
     */
    private function dummyArtworkEntityAttributes(int $userId): array
    {
        $size = $this->generateSize();
        $componentQuantity = count(json_decode($size));

        return [
            'name' => fake()->name(),
            'description' => fake()->text(400),
            'category' => $this->artworkRandomCategory(),
            'user_id' => $userId,
            'topic' => $this->artworkRandomTopic(),
            'price' => fake()->numberBetween(0, 10000),
            'size' => $this->generateSize(),
            'number_components' => $componentQuantity,
            'color' => array_rand(Artwork::getColorsMenu()),
            'created_year' => fake()->year(),
        ];
    }

    /**
     * Сформировать случайную категорию работы
     *
     * @return string
     */
    private function artworkRandomCategory(): string
    {
        return array_rand(Artwork::artwork_types_list());
    }

    /**
     * Сформировать случайную тему работы
     *
     * @return string
     */
    private function artworkRandomTopic(): string
    {
        return array_rand(Artwork::artwork_topics_list());
    }

    /**
     * Создать работу автора вместе с изображениями
     *
     * @param \Source\Entity\User\Models\User $user
     *
     * @return array
     */
    private function createUserArtwork(User $user): array
    {
        $artworkAttributes = $this->dummyArtworkEntityAttributes($user->id);
        $entity = new Artwork($artworkAttributes);
        $images = $this->artworkFiles(rand(1, 9));
        return $entity->store(['images' => $images, 'tags' => '']);
    }

    /**
     * Создать указанное количество авторских работ пользователя
     *
     * @param \Source\Entity\User\Models\User $user
     * @param int                             $quantity
     *
     * @return void
     */
    private function createArtworksForUser(User $user, int $quantity): void
    {
        for($i = 1; $i <= $quantity; $i++) {
            $this->createUserArtwork($user);
        }
    }

    /**
     * Сформировать изображения для авторской работы
     *
     * @param int $quantity - количество
     *
     * @return array
     */
    private function artworkFiles(int $quantity = 8): array
    {
        if (empty($this->factoryFileStorage)) {
            $this->factoryFileStorage = new FactoryStorageClass('user_artworks');
        }

        return array_slice($this->factoryFileStorage->getFiles(), 0, $quantity - 1);
    }

    private function randDepth(): null|int
    {
        $items = [null, 0, 1, 2, 3, 4, 5];
        // null or integer
        return $items[array_rand($items, 1)];
    }

    /**
     * Создаем размер работы в формате json. Значение уже готово для сохранения в БД
     *
     * @return string - json с размером работы
     */
    private function generateSize(): string
    {
        $size = [];
        $max = count(config('app.artwoo.artwork.component_quantity'));

        for ($i = 0; $i < $max; $i++) {
            $size[] = [
                'width' => fake()->randomFloat(1, 0.1, 1000),
                'height' => fake()->randomFloat(1, 0.1, 1000),
                'depth' => $i % 2 === 0 ? fake()->randomFloat(1, 0.1, 1000) : 0,
            ];
        }

        return json_encode($size);
    }
}
