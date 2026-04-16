<?php

declare(strict_types=1);

namespace AcMarche\Document\Database\Factories;

use AcMarche\Document\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\AcMarche\Document\Models\Category>
 */
final class CategoryFactory extends Factory
{
    #[\Override]
    protected $model = Category::class;

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
