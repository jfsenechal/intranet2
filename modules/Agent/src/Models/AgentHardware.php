<?php

declare(strict_types=1);

namespace AcMarche\Agent\Models;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Connection('maria-agent')]
#[Table(name: 'agent_hardware')]
#[Fillable([
    'agent_id',
    'existing_pc',
    'new_pc',
    'other',
    'vpn',
])]
final class AgentHardware extends Model
{
    /**
     * @return BelongsTo<Agent>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    protected function casts(): array
    {
        return [
            'vpn' => 'boolean',
        ];
    }
}
