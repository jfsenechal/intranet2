<?php

declare(strict_types=1);

namespace AcMarche\Pst\Database\Factories;

use AcMarche\App\Enums\DepartmentEnum;
use AcMarche\Pst\Enums\ActionScopeEnum;
use AcMarche\Pst\Models\StrategicObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

final class StrategicObjectiveFactory extends Factory
{
    protected $model = StrategicObjective::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'position' => fake()->numberBetween(1, 100),
            'department' => DepartmentEnum::VILLE->value,
            'scope' => fake()->randomElement(ActionScopeEnum::cases())->value,
        ];
    }
}
