<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Models;

use AcMarche\Courrier\Enums\RolesEnum;

trait UserCourrierTrait
{
    public function getCourrierDepartments(): array
    {
        $departments = [];
        if ($this->hasRole(RolesEnum::ROLE_INDICATEUR_CPAS->value)) {
            $departments[] = RolesEnum::ROLE_INDICATEUR_CPAS->value;
        }

        if ($this->hasRole(RolesEnum::ROLE_INDICATEUR_VILLE->value)) {
            $departments[] = RolesEnum::ROLE_INDICATEUR_VILLE->value;
        }

        return $departments;
    }
}
