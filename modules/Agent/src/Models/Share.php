<?php

declare(strict_types=1);

namespace AcMarche\Agent\Models;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Connection('maria-agent')]
#[Fillable([
    'agent_id',
    'shared_by',
    'shared_for',
])]
final class Share extends Model
{
    /**
     * @return BelongsTo<Agent>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
