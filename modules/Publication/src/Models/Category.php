<?php

declare(strict_types=1);

namespace AcMarche\Publication\Models;

use AcMarche\Publication\Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-publication')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'name',
    'url',
    'wpCategoryId',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'publication_categories')]
final class Category extends Model
{
    use HasFactory;

    #[Override]
    public $timestamps = false;

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
