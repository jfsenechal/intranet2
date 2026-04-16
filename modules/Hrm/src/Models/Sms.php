<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'employee_id',
    'phone_number',
    'message',
    'reminder_date',
    'other_reminder_date',
    'sent_at',
    'result',
    'updated_by',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'sms')]
final class Sms extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * @return BelongsTo<Employee>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function casts(): array
    {
        return [
            'reminder_date' => 'date',
            'other_reminder_date' => 'date',
            'sent_at' => 'date',
        ];
    }
}
