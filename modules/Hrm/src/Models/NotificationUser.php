<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'notification_id',
    'user',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'notification_users')]
final class NotificationUser extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    #[\Override]
    public $timestamps = false;

    /**
     * @return BelongsTo<HrNotification>
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(HrNotification::class, 'notification_id');
    }
}
