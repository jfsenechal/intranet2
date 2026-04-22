<?php

declare(strict_types=1);

namespace AcMarche\Security\Repository;

use AcMarche\Security\Ldap\UserLdap;
use LdapRecord\Query\Collection;

final class LdapRepository
{
    /**
     * @return array<string, string>
     */
    public function listsAndServices(): array
    {
        $items = $this->toOptions($this->allLists())
            + $this->toOptions($this->allServices());

        ksort($items);

        return $items;
    }

    public function allLists(): Collection
    {
        return UserLdap::query()
            ->setBaseDn(config('security.ldap.lists_dn'))
            ->orderBy('sAMAccountName')
            ->get();
    }

    public function allServices(): Collection
    {
        return UserLdap::query()
            ->setBaseDn(config('security.ldap.services_dn'))
            ->orderBy('sAMAccountName')
            ->get();
    }

    /**
     * @return array<string, string>
     */
    private function toOptions(Collection $entries): array
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
