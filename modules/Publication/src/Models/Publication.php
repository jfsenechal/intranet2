<?php

declare(strict_types=1);

namespace AcMarche\Publication\Models;

use AcMarche\Publication\Database\Factories\PublicationFactory;
use AcMarche\Security\Models\HasUserAdd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Publication extends Model
{
    use HasFactory;
    use HasUserAdd;

    protected $connection = 'maria-publication';

    protected $fillable = [
        'category_id',
        'name',
        'url',
        'expire_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function newFactory(): PublicationFactory
    {
        return PublicationFactory::new();
    }

    protected function casts(): array
    {
        return [
            'expire_date' => 'datetime',
        ];
    }
}
