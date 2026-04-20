<?php

declare(strict_types=1);

namespace AcMarche\Agent\Models;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Connection('maria-agent')]
#[Table(name: 'agent_phone')]
#[Fillable([
    'agent_id',
    'existing_number',
    'new_number',
    'external_number',
    'mobile_number',
])]
final class AgentPhone extends Model
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
            'new_number' => 'boolean',
            'external_number' => 'boolean',
        ];
    }
}
