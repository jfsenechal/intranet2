<?php

declare(strict_types=1);

namespace AcMarche\Security\Repository;

use AcMarche\App\Enums\DepartmentEnum;
use AcMarche\Security\Ldap\UserLdap;
use App\Models\User;

final class UserRepository
{
    public static string $department_selected_key = 'department_selected';

    public static function getUsersForSelect(): array
    {
        $users = [];
        foreach (User::all() as $user) {
            $users[$user->id] = $user->first_name.' '.$user->last_name;
        }

        return $users;
    }

    public static function find(int $userId): ?User
    {
        return User::find($userId);
    }

    public static function listUsersFromLdapForSelect(): array
    {
        $users = [];
        foreach (UserLdap::all() as $userLdap) {
            if (! $userLdap->getFirstAttribute('mail')) {
                continue;
            }
            if (! self::isActif($userLdap)) {
                continue;
            }
            $username = $userLdap->getFirstAttribute('samaccountname');
            $users[$username] = $userLdap->getFirstAttribute('sn').' '.$userLdap->getFirstAttribute('givenname');
        }

        asort($users, SORT_LOCALE_STRING);

        return $users;
    }

    public static function departmentSelected(): string
    {
        $department = session(self::$department_selected_key);
        if ($department) {
            return $department;
        }

        if (auth()->user() && count(auth()->user()->departments) > 0) {
            return auth()->user()->departments[0];
        }

        return DepartmentEnum::VILLE->value;
    }

    public static function listUsersFromLdap(): array
    {
        $users = [];
        foreach (User::all() as $userLdap) {
            if (! $userLdap->getFirstAttribute('mail')) {
                continue;
            }
            if (! self::isActif($userLdap)) {
                continue;
            }
            $username = $userLdap->getFirstAttribute('samaccountname');
            $users[$username] = $userLdap;
        }

        usort($users, function (UserLdap $a, UserLdap $b) {
            return strcasecmp($a->getFirstAttribute('sn'), $b->getFirstAttribute('sn'));
        });

        return $users;
    }

    public static function listDepartmentOfCurrentUser(): array
    {
        $departments = [];
        if (auth()->user()) {
            foreach (auth()->user()->departments as $department) {
                $departments[$department] = $department;
            }
        }

        return $departments;
    }

    private static function isActif(UserLdap $userLdap): bool
    {
        return $userLdap->getFirstAttribute('userAccountControl') !== 66050;
    }
}
