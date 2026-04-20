<?php

declare(strict_types=1);

namespace AcMarche\Agent\Models;

use AcMarche\Security\Models\HasUserAdd;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Connection('maria-agent')]
#[Fillable([
    'last_name',
    'first_name',
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
final class Agent extends Model
{
    use HasUserAdd;
    use SoftDeletes;

    /**
     * @return HasOne<AgentHardware>
     */
    public function hardware(): HasOne
    {
        return $this->hasOne(AgentHardware::class);
    }

    /**
     * @return HasOne<AgentPhone>
     */
    public function phone(): HasOne
    {
        return $this->hasOne(AgentPhone::class);
    }

    /**
     * @return BelongsToMany<ExternalApplication>
     */
    public function externalApplications(): BelongsToMany
    {
        return $this->belongsToMany(ExternalApplication::class, 'agent_external_application');
    }

    /**
     * @return BelongsToMany<Folder>
     */
    public function folders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'agent_folder');
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

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
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
