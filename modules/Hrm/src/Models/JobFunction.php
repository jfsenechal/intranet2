<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'name',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'job_functions')]
final class JobFunction extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    #[\Override]
    public $timestamps = false;

    /**
     * @return HasMany<Application>
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
