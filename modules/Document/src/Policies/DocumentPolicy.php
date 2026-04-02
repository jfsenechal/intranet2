<?php

declare(strict_types=1);

namespace AcMarche\Document\Policies;

use AcMarche\Document\Enums\RolesEnum;
use AcMarche\Document\Models\Document;
use App\Models\User;

final class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $this->isAdministrator($user, $document);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $this->isAdministrator($user, $document);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }

    private function isAdministrator(User $user, Document $document): bool
    {
        if ($user->isAdministrator()) {
            return true;
        }
        if ($user->hasOneOfThisRoles(
            [
                RolesEnum::ROLE_DOCUMENT_ADMIN->value,
            ]
        )) {
            return true;
        }
        if ($user->username === $document->user_add) {
            return true;
        }

        return false;
    }
}
