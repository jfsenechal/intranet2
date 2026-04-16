<?php

declare(strict_types=1);

namespace AcMarche\News\Models;

use AcMarche\News\Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-news')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable(['name', 'icon', 'color'])]
final class Category extends Model
{
    use HasFactory;

    #[\Override]
    public $timestamps = false;

    /**
     * @return HasMany<News>
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    // Model::automaticallyEagerLoadRelationships();

    /**
     * To resolve name
     * static::resolveFactoryName($modelName);
     */
    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
