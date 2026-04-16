<?php

declare(strict_types=1);

namespace AcMarche\Pst\Database\Factories;

use AcMarche\Pst\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\AcMarche\Pst\Models\History>
 */
final class HistoryFactory extends Factory
{
    #[\Override]
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
