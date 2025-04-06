<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Source\Access\Enums\RoleEnum;
use Source\Auth\Dictionaries\AuthType;
use Source\Entity\User\Dictionaries\CreativityType;
use Source\Entity\User\Dictionaries\UserStatus;
use Source\Entity\User\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\app\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'login' => fake()->userName(),
          'email' => fake()->unique()->safeEmail(),
          'birthday' => fake()->date(config('app.artwoo.date.mysql_format')),
          'password' => fake()->password(),
          'policyagreed' => fake()->boolean(),
          'role' => RoleEnum::author->value,
          'status' => UserStatus::DRAFT->value,
          'auth' => AuthType::MANUAL->value,
          'freelance'=> fake()->boolean(),
          'creativity_type' => $this->getCreativity(),
          'about' => mb_substr(fake()->words(8, true), 0, 100),
          'show_socials' => fake()->boolean(),
        ];
    }

    private function getCreativity(): string
    {
        $rand = array_rand(CreativityType::cases(), 1);
        return CreativityType::cases()[$rand]->value;
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
//    public function unverified(): static
//    {
//        return $this->state(fn (array $attributes) => [
//            'email_verified_at' => null,
//        ]);
//    }
}
