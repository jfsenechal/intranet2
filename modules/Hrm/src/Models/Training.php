<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use AcMarche\Security\Models\HasUserAdd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'employee_id',
    'name',
    'description',
    'start_date',
    'end_date',
    'college_date',
    'reminder_date',
    'duration_hours',
    'training_type',
    'certificate_file',
    'certificate_received',
    'certificate_received_at',
    'granted_by',
    'granted_at',
    'is_closed',
    'user_add',
    'updated_by',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'trainings')]
final class Training extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use HasUserAdd;

    /**
     * @return BelongsTo<Employee>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function booted(): void
    {
        self::bootHasUser();
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'college_date' => 'date',
            'reminder_date' => 'date',
            'certificate_received_at' => 'date',
            'granted_at' => 'date',
            'certificate_received' => 'boolean',
            'is_closed' => 'boolean',
        ];
    }
}
