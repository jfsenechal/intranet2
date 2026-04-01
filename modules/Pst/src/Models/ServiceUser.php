<?php

declare(strict_types=1);

namespace AcMarche\Pst\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ServiceUser extends Model
{
    protected $connection = 'maria-pst';

    protected $fillable = [
        'username',
        'service_id',
    ];

    protected $casts = [
    ];

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
