<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Database\Factories;

use Override;
use AcMarche\Courrier\Models\Sender;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Sender>
 */
final class SenderFactory extends Factory
{
    #[Override]
    protected $model = Sender::class;

    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'department' => null,
        ];
    }
}
