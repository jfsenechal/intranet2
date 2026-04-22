<?php

declare(strict_types=1);

namespace AcMarche\Security\Repository;

use AcMarche\Security\Ldap\UserLdap;
use LdapRecord\Models\Model;
use LdapRecord\Query\Collection;

final class LdapRepository
{
    public static function allUsers(): Collection
    {
        return UserLdap::all();
    }

    public static function findByUsername(string $username): ?Model
    {
        return UserLdap::query()->findBy('sAMAccountName', $username);
    }

    public static function existsByUsername(?string $username): bool
    {
        if ($username === null || $username === '') {
            return false;
        }

        return self::findByUsername($username) instanceof Model;
    }

    public static function allLists(): Collection
    {
        return UserLdap::query()
            ->setBaseDn(config('security.ldap.lists_dn'))
            ->orderBy('sAMAccountName')
            ->get();
    }

    public static function allServices(): Collection
    {
        return UserLdap::query()
            ->setBaseDn(config('security.ldap.services_dn'))
            ->orderBy('sAMAccountName')
            ->get();
    }

    /**
     * @return array<string, string>
     */
    public static function listsAndServices(): array
    {
        $items = self::toOptions(self::allLists())
            + self::toOptions(self::allServices());

        ksort($items);

        return $items;
    }

    /**
     * @return array<string, string>
     */
    private static function toOptions(Collection $entries): array
    {
        $options = [];
        foreach ($entries as $entry) {
            $username = $entry->getFirstAttribute('sAMAccountName');
            if ($username === null) {
                continue;
            }

            $options[$username] = $entry->getFirstAttribute('displayName') ?? $username;
        }

        return $options;
    }
}
