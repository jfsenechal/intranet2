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
    'name',
    'old_value',
    'new_value',
    'username',
])]
final class History extends Model
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
            'old_value' => 'array',
            'new_value' => 'array',
        ];
    }
}
