<?php

declare(strict_types=1);

namespace AcMarche\Security\Database\Factories;

use AcMarche\Security\Models\Role;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(Role::class)]
final class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'label' => fake()->name(),
        ];
    }
}
