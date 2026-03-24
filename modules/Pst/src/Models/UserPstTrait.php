<?php

declare(strict_types=1);

namespace AcMarche\Pst\Models;

use AcMarche\Security\Repository\UserRepository;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait UserPstTrait
{
    protected $connection = 'maria-pst';

    /**
     * @return BelongsToMany<Service>
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_user', 'username', 'service_id', 'username', 'id');
    }

    /**
     * @return BelongsToMany<Action>
     */
    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'action_user', 'username', 'action_id', 'username', 'id');
    }

    #[Scope]
    public function forSelectedDepartment(Builder $query): void
    {
        $department = UserRepository::departmentSelected();
        $query->whereJsonContains('departments', $department);
    }
}
