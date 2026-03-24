<?php

declare(strict_types=1);

namespace  AcMarche\Pst\Database\Factories;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HistoryFactory extends Factory
{
    protected $model = History::class;

    public function definition(): array
    {
        return [
            'property' => fake()->name(),
            'body' => fake()->text(),
            'user_add' => fake()->userName(),
        ];
    }
}
