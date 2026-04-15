<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Models;

use AcMarche\Courrier\Database\Factories\SenderFactory;
use AcMarche\Courrier\Repository\DepartmentScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[UseFactory(SenderFactory::class)]
#[ScopedBy([DepartmentScope::class])]
final class Sender extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;

    protected $connection = 'maria-courrier';

    protected $fillable = [
        'slug',
        'name',
        'department',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function incomingMails(): BelongsToMany
    {
        return $this->belongsToMany(IncomingMail::class, 'incoming_mail_service')
            ->withPivot('is_primary');
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class, 'recipient_service');
    }

    protected static function newFactory(): SenderFactory
    {
        return SenderFactory::new();
    }

    protected function casts(): array
    {
        return [

        ];
    }
}
