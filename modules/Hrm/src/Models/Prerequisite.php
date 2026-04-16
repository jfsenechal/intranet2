<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'name',
    'profession',
    'description',
    'user',
    'employer_id',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'prerequisites')]
final class Prerequisite extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    #[\Override]
    public $timestamps = false;

    /**
     * @return BelongsTo<Employer>
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * @return HasMany<Employee>
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
