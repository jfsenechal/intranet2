<?php

declare(strict_types=1);

namespace AcMarche\Pst\Database\Factories;

use App\Models\Odd;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OddFactory extends Factory
{
    protected $model = Odd::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
