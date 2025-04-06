<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Source\Entity\User\Models\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Source\Entity\Artwork\Models\Artwork as ArtworkEntity;

/**
 * Тесты для проверки модели Artwork
 * Файловое хранилище в этом случае не проверяется
 *
 * @todo добавить проверку файлового хранилища
 */
class ArtworkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Базовая проверка, что сущность вообще создается (заполнение только обязательных полей)
     *
     * @return void
     */
    public function test_created_successfully(): void
    {
        $acting = $this->actingUser();
        $response = $acting->post('/artwork/edit/', $this->dummyFormData(),
            ['Content-Type' => 'multipart/form-data']);
        $artwork = ArtworkEntity::where('name', '=', $this->dummyFormData()['name'])->first();
        $response->assertRedirect("/artwork/{$artwork->id}");
    }

    public function test_images_validation_work(): void
    {
        $data = $this->dummyFormData();
        $actual = $data;
        $actual['images'] = null;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type' => 'multipart/form-data']);
        $response->assertInvalid(['images']);

        $actual = $data;
        $actual['images'] = [UploadedFile::fake()->create('image.jpg', 6000)];
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid(['images.0']);

        $actual = $data;
        $actual['images'] = $this->createFakeImages($this->maxUploadImages() + 1);
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid(['images']);
    }

    /**
     * Проверяем, что при отсутствии обязательного поля у нас сущность не создается
     *
     * @return void
     */
    public function test_not_created_if_required_fields_not_set(): void
    {
        $data = $this->dummyFormData();
        // название не указано
        $actual = $data;
        $actual['name'] = null;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid(['name']);

        $actual = $data;
        // категория не задана
        $actual['category'] = null;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid(['category']);

        $actual = $data;
        unset($actual['width'][0]);
        // ширина не задан
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid();

        $actual = $data;
        unset($actual['height'][0]);
        // высота не задана
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid();

        $actual = $data;
        // тема не задана
        $actual['topic'] = null;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid(['topic']);

        $actual = $data;
        // описание не указано
        $actual['description'] = null;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type', 'multipart/form-data']);
        $response->assertInvalid(['description']);
    }

    /**
     * Проверяем, что необязательные поля сохраняются
     *
     * @return void
     */
    public function test_optional_param_saved(): void
    {
        $data = $this->dummyFormData();
        // проверить указание стоимости
        $actual = $data;
        $actual['price'] = 2500;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type' => 'multipart/form-data']);
        $artwork = ArtworkEntity::where('price', '=', $actual['price'])->first();
        $response->assertRedirect("/artwork/{$artwork->id}");

        // проверить указаине года создания работы
        $actual = $data;
        $actual['created_year'] = 2025;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type' => 'multipart/form-data']);
        $artwork = ArtworkEntity::where('created_year', '=', $actual['created_year'])->first();
        $response->assertRedirect("/artwork/{$artwork->id}");

        // проверить указание цвета работы
        $actual = $data;
        $actual['color'] = array_rand(ArtworkEntity::getColorsMenu());
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type' => 'multipart/form-data']);
        $artwork = ArtworkEntity::where('color', '=', $actual['color'])->first();
        $response->assertRedirect("/artwork/{$artwork->id}");

        // количество составных частей
        $actual = $data;
        unset($actual['width']);
        unset($actual['height']);
        unset($actual['depth']);
        $actual = array_merge($actual, $this->generateSize(3));
        $actual['number_components'] = 3;
        $response = $this->actingUser()->post('/artwork/edit/', $actual, ['Content-Type' => 'multipart/form-data']);
        $artwork = ArtworkEntity::where('number_components', '=', 3)->first();
        $response->assertRedirect("/artwork/{$artwork->id}");
    }

    /**
     * Проверить, что работа удаляется корректно
     *
     * @return void
     * @throws \Exception
     */
    public function test_artwork_delete_successfully(): void
    {
        $data = $this->dummyFormData();
        $artworkName = $data['name'];
        $this->actingUser()->post('/artwork/edit/', $data, ['Content-Type', 'multipart/form-data']);
        /** @var ArtworkEntity $artworkEntity */
        $artworkEntity = ArtworkEntity::where('name', '=', $artworkName)->first();
        $this->assertNotNull($artworkEntity);
        $artworkEntity->delete();
        $artworkEntity = ArtworkEntity::where('name', '=', $artworkName)->first();
        $this->assertNull($artworkEntity);
    }

    private function allowedCategories(): array
    {
        return \array_keys(\Source\Entity\Artwork\Models\Artwork::artwork_types_list());
    }

    private function allowedTopics(): array
    {
        return \array_keys(\Source\Entity\Artwork\Models\Artwork::artwork_topics_list());
    }

    /**
     * Минимально необходимые данные для заполнения формы
     *
     * @return array
     */
    private function dummyFormData(): array
    {
        $defaultSizeArray = [];
        $defaultSizeArray['width'][] = 100;
        $defaultSizeArray['height'][] = 150;
        $defaultSizeArray['depth'][] = 0;

        return array_merge($defaultSizeArray, [
            'name' => 'testname1',
            'category' => $this->allowedCategories()[0],
            'topic' => $this->allowedTopics()[0],
            'description' => 'Some description',
            'images' => [UploadedFile::fake()->create('image.jpg', 1000)],
        ]);
    }

    /**
     * Совершить действие от активного аутентифицированного пользователя
     *
     * @return ArtworkTest
     */
    private function actingUser()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->markEmailAsVerified();
        return $this->actingAs($user->fresh());
    }

    /**
     * Создать указанное количество файлов
     *
     * @param int $quantity
     * @param int $size
     * @param string $ext
     * @return array
     */
    private function createFakeImages(int $quantity, int $size = 2000, string $ext = 'jpg'): array
    {
        $fi = [];
        for ($i = 0; $i < $quantity; $i++) {
            $file = UploadedFile::fake()->create("image_{$i}.{$ext}", $size);
            $fi[] = $file;
        }

        return $fi;
    }

    private function maxUploadImages(): int
    {
        return (int) config('app.artwoo.artwork.max_files');
    }

    /**
     * Создаем размер работы
     * (Максимальное количество - 5)
     * Здесь проверка на максимальное количество не выполяется
     *
     * @param int $length - сколько массивов с размерами создать
     * @return array
     */
    private function generateSize(int $length): array
    {
        $size = [];

        for ($i = 0; $i < $length; $i++) {
            foreach (['width', 'height', 'depth'] as $prop) {
                $size[$prop][$i] = fake()->numberBetween(1, 1000);
            }
        }

        return $size;
    }
}
