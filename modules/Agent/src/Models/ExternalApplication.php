<?php

declare(strict_types=1);

namespace AcMarche\Agent\Models;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Connection('maria-agent')]
#[Fillable([
    'name',
    'description',
    'service_id',
])]
final class ExternalApplication extends Model
{
    /**
     * @return BelongsToMany<Agent>
     */
    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(Agent::class, 'agent_external_application');
    }
}
