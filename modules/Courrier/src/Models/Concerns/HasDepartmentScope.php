<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait HasDepartmentScope
{
    public static function bootHasDepartmentScope(): void
    {
        static::addGlobalScope('department', function (Builder $query): void {
            $departments = static::getCurrentUserDepartment();
            if (count($departments) > 0) {
                $query->where($query->getModel()->getTable().'.department', 'IN', $departments);
            }
        });

        static::creating(function (Model $model): void {
            if (empty($model->department)) {
                $departments = static::getCurrentUserDepartment();
                if (count($departments) > 0) {
                    $model->department = $departments;
                }
            }
        });
    }

    private static function getCurrentUserDepartment(): array
    {
        $user = auth()->user();

        if ($user === null) {
            return [];
        }

        return $user->getCourrierDepartments();
    }
}
