<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use AcMarche\Security\Models\HasUserAdd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'title',
    'object_id',
    'object_type',
    'employer_id',
    'user_add',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'hr_notifications')]
final class HrNotification extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use HasUserAdd;

    /**
     * @return BelongsTo<Employer>
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * @return HasMany<NotificationUser>
     */
    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class, 'notification_id');
    }

    protected static function booted(): void
    {
        self::bootHasUser();
    }
}
