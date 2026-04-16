<?php

declare(strict_types=1);

namespace AcMarche\Pst\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-pst')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'username',
    'action_id',
])]
final class ActionMandatory extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    #[Override]
    protected $casts = [
    ];

    /**
     * @return BelongsTo<Action, $this>
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
