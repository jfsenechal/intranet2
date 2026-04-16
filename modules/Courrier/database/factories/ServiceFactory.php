<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Database\Factories;

use Override;
use AcMarche\Courrier\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
final class ServiceFactory extends Factory
{
    #[Override]
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'slugname' => Str::slug($name),
            'name' => $name,
            'initials' => Str::upper(Str::substr($name, 0, 3)),
            'department' => null,
        ];
    }
}
