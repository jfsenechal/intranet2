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
    'service_id',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'service_user')]
final class ServiceUser extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    #[Override]
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
