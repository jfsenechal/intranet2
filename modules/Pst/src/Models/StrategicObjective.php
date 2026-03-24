<?php

declare(strict_types=1);

namespace AcMarche\Pst\Models;

use AcMarche\Pst\Enums\ActionScopeEnum;
use AcMarche\App\Enums\DepartmentEnum;
use AcMarche\Pst\Models\Scopes\HasDepartmentScope;
use  AcMarche\Pst\Database\Factories\StrategicObjectiveFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

#[UseFactory(StrategicObjectiveFactory::class)]
final class StrategicObjective extends Model
{
    use HasDepartmentScope, HasFactory, Notifiable, Searchable;

    protected $connection = 'maria-pst';
    protected $fillable = [
        'name',
        'position',
        'department',
        'scope',
    ];

    protected $casts = [
        'scope' => ActionScopeEnum::class,
        'department' => DepartmentEnum::class,
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'department' => $this->department,
        ];
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'pst_strategic_objectives_index';
    }

    public function isInternal(): bool
    {
        return $this->scope === ActionScopeEnum::INTERNAL;
    }

    /**
     * Get the operational objectives for the strategic objective.
     *
     * @return HasMany<OperationalObjective>
     */
    public function oos(): HasMany
    {
        return $this->hasMany(OperationalObjective::class);
    }
}
