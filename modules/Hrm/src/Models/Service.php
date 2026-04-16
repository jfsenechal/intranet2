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
    'abbreviation',
    'direction_id',
    'employer_id',
    'address',
    'postal_code',
    'city',
    'email',
    'phone',
    'gsm',
    'notes',
    'user_add',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'services')]
final class Service extends Model
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
     * @return BelongsTo<Direction>
     */
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    /**
     * @return BelongsTo<Employer>
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * @return HasMany<Contract>
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * @return HasMany<Operator>
     */
    public function operators(): HasMany
    {
        return $this->hasMany(Operator::class);
    }

    protected static function booted(): void
    {
        self::bootHasUser();
    }
}
