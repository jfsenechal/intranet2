<?php

declare(strict_types=1);

namespace AcMarche\Pst\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ActionUser extends Model
{
    protected $connection = 'maria-pst';

    protected $table = 'action_user';

    protected $fillable = [
        'username',
        'action_id',
    ];

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
