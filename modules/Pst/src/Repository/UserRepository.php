<?php

declare(strict_types=1);

namespace AcMarche\Pst\Repository;

use AcMarche\Pst\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class UserRepository
{
    /**
     * Get mandataries (users with MANDATAIRE role) for an action.
     *
     * @return Collection<int, User>
     */
    public static function mandataries(int $actionId): Collection
    {
        return User::query()
            ->from(DB::raw('`intranet`.`users`'))
            ->join(DB::raw('`pst`.`action_mandatory`'), 'intranet.users.username', '=', 'pst.action_mandatory.username')
            ->whereIn('intranet.users.id', function ($subquery) {
                $subquery
                    ->select('intranet.users.id')
                    ->from(DB::raw('`intranet`.`users`'))
                    ->join(DB::raw('`intranet`.`role_user`'), 'intranet.users.id', '=', 'intranet.role_user.user_id')
                    ->join(DB::raw('`intranet`.`roles`'), 'intranet.role_user.role_id', '=', 'intranet.roles.id')
                    ->where('intranet.roles.name', RoleEnum::MANDATAIRE->value);
            })
            ->where('pst.action_mandatory.action_id', $actionId)
            ->select('intranet.users.*')
            ->distinct()
            ->get();
    }
}
