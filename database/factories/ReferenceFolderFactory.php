<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Source\Entity\Reference\Models\Folder;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReferenceFolderFactory extends Factory
{
    // пользователь по умолчанию, к которому создаются записи
    protected int $defaultUser = 1;
    // модель
    protected $model = Folder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(52),
            'description' => $this->faker->text(300),
            'user_id' => $this->defaultUser,
            'time_visited' => date('Y-m-d H:i:s'),
            'automatic_deletion' => $this->faker->boolean(),
        ];
    }
}
