<?php

declare(strict_types=1);

namespace AcMarche\Agent\Models;

use AcMarche\Security\Models\HasUserAdd;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Connection('maria-agent')]
#[Fillable([
    'emails',
    'supervisors',
    'location',
    'notes',
    'modules',
    'employee_id',
    'uuid',
    'username',
    'no_mail',
])]
final class Profile extends Model
{
    use HasUserAdd;
    use SoftDeletes;

    /**
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    /**
     * @return HasOne<ProfileHardware>
     */
    public function hardware(): HasOne
    {
        return $this->hasOne(ProfileHardware::class);
    }

    /**
     * @return HasOne<ProfilePhone>
     */
    public function phone(): HasOne
    {
        return $this->hasOne(ProfilePhone::class);
    }

    /**
     * @return BelongsToMany<ExternalApplication>
     */
    public function externalApplications(): BelongsToMany
    {
        return $this->belongsToMany(ExternalApplication::class, 'profile_external_application');
    }

    /**
     * @return BelongsToMany<Folder>
     */
    public function folders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'profile_folder');
    }

    /**
     * @return HasMany<History>
     */
    public function histories(): HasMany
    {
        return $this->hasMany(History::class);
    }

    /**
     * @return HasMany<Share>
     */
    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }

    protected static function booted(): void
    {
        self::bootHasUser();
    }

    protected function casts(): array
    {
        return [
            'emails' => 'array',
            'supervisors' => 'array',
            'modules' => 'array',
            'no_mail' => 'boolean',
        ];
    }
}
