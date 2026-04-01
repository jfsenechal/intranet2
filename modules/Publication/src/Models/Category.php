<?php

declare(strict_types=1);

namespace AcMarche\Publication\Models;

use AcMarche\Publication\Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'publication_categories';

    protected $connection = 'maria-publication';

    protected $fillable = [
        'name',
        'url',
        'wpCategoryId',
    ];

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
