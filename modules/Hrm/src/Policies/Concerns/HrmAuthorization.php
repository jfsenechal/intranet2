<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Policies\Concerns;

use AcMarche\Hrm\Enums\RolesEnum;
use App\Models\User;

trait HrmAuthorization
{
    protected function isAdmin(User $user): bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return $user->hasRole(RolesEnum::ROLE_GRH_ADMIN->value);
    }

    protected function canReadCpas(User $user): bool
    {
        return $user->hasRole(RolesEnum::ROLE_GRH_CPAS_READ->value);
    }

    protected function canReadVille(User $user): bool
    {
        return $user->hasRole(RolesEnum::ROLE_GRH_VILLE_READ->value);
    }

    protected function isDirectionHead(User $user): bool
    {
        return $user->hasRole(RolesEnum::ROLE_GRH_DIRECTION->value);
    }

    protected function hasAnyHrmRole(User $user): bool
    {
        return $user->hasOneOfThisRoles([
            RolesEnum::ROLE_GRH_ADMIN->value,
            RolesEnum::ROLE_GRH_CPAS_READ->value,
            RolesEnum::ROLE_GRH_VILLE_READ->value,
            RolesEnum::ROLE_GRH_DIRECTION->value,
        ]);
    }

    protected function hasReadAccess(User $user): bool
    {
        if ($this->canReadCpas($user)) {
            return true;
        }

        return $this->canReadVille($user);
    }

    private function hasWriteAccess(User $user) {}
}
