<?php

declare(strict_types=1);

namespace AcMarche\Pst\Database\Factories;

use AcMarche\Pst\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\AcMarche\Pst\Models\Media>
 */
final class MediaFactory extends Factory
{
    #[\Override]
    protected $model = Media::class;

    public function definition(): array
    {
        return [

        ];
    }
}
