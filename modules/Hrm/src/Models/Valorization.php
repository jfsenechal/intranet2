<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'employee_id',
    'employer_name',
    'duration',
    'regime',
    'content',
    'file_name',
    'updated_by',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'valorizations')]
final class Valorization extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * @return BelongsTo<Employee>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
