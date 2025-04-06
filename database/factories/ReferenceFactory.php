<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Source\Entity\Reference\Models\Reference;
use Source\Lib\FactoryStorageClass;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReferenceFactory extends Factory
{
    private FactoryStorageClass $factoryFileStorage;
    protected $model = Reference::class;
    protected int $defaultUser = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(52),
        ];
    }

    /**
     * Создаем файлы после создания сущности
     *
     * @return $this
     */
    public function configure(): static
    {
        // заполняем реальными файлами
        return $this->afterCreating(function (Reference $reference) {
            $fileArea = 'user_references' . "_{$reference->id}";
            $fs = new FileStorage();
            $fs->saveOne($this->getFile(), new FileIdentityDTO('reference', $this->defaultUser, $reference->folder_id, $fileArea));
        });
    }

    /**
     * Получаем один случайный файл из списка доступных для данного компонента
     *
     * @return File
     */
    private function getFile(): File
    {
        if (empty($this->factoryFileStorage)) {
            $this->factoryFileStorage = new FactoryStorageClass('references');
        }

        return $this->factoryFileStorage->getFiles()[0];
    }


}
