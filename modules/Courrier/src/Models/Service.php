<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Models;

use AcMarche\Courrier\Database\Factories\ServiceFactory;
use AcMarche\Courrier\Models\Concerns\HasDepartmentScope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[UseFactory(ServiceFactory::class)]
#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-courrier')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'slugname',
    'name',
    'initials',
    'department',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'courrier_services')]
final class Service extends Model
{
    use HasDepartmentScope;
    use HasFactory;
    use HasSlug;

    #[\Override]
    public $timestamps = false;

    public function incomingMails(): BelongsToMany
    {
        return $this->belongsToMany(IncomingMail::class, 'incoming_mail_service')
            ->withPivot('is_primary');
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class, 'recipient_service');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slugname');
    }

    protected static function newFactory(): ServiceFactory
    {
        return ServiceFactory::new();
    }

    protected function casts(): array
    {
        return [

        ];
    }
}
