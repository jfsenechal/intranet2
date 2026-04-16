<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use AcMarche\Security\Models\HasUserAdd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'name',
    'slug',
    'director',
    'abbreviation',
    'employer_id',
    'user_add',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'directions')]
final class Direction extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use HasUserAdd;
    use HasSlug;


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug');
    }

    /**
     * @return BelongsTo<Employer>
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * @return HasMany<Service>
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return HasMany<Contract>
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    protected static function booted(): void
    {
        self::bootHasUser();
    }
}
