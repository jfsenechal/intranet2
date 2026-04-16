<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'name',
    'slug',
    'parent_id',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'employers')]
final class Employer extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * @return BelongsTo<Employer>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<Employer>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return HasMany<Direction>
     */
    public function directions(): HasMany
    {
        return $this->hasMany(Direction::class, 'employer_id');
    }

    /**
     * @return HasMany<Employee>
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'saved_employer_id');
    }
}
