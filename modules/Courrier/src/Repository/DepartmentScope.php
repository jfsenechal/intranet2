<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class DepartmentScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $departments = self::getCurrentUserDepartment();
        if (count($departments) > 0) {
            $builder->where('department', 'IN', $departments);
        }
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
