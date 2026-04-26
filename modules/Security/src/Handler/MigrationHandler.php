<?php

declare(strict_types=1);

namespace AcMarche\Security\Handler;

use AcMarche\Agent\Filament\Resources\Profiles\ProfileResource;
use AcMarche\Courrier\Filament\Resources\IncomingMails\IncomingMailResource;
use AcMarche\Document\Filament\Resources\Documents\DocumentResource;
use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use AcMarche\Mileage\Filament\Resources\Trips\TripResource;
use AcMarche\News\Filament\Resources\News\NewsResource;
use AcMarche\Pst\Filament\Resources\ActionPst\ActionPstResource;
use AcMarche\Publication\Filament\Resources\Publications\PublicationResource;
use AcMarche\Security\Filament\Resources\Users\UserResource;
use AcMarche\Security\Models\Module;
use Illuminate\Support\Collection;

final class MigrationHandler
{
    public const array modules_to_skip = [1, 2, 21, 22, 23, 26, 33, 49, 50];

    public static function urlModule(Module $module): ?string
    {
        $resource = self::findTheResource($module);
        if ($resource) {
            return $resource;
        }

        return null;
    }

    public static function findTheResource(Module $module): ?string
    {
        return match ($module->id) {
            6 => EmployeeResource::getUrl('index', panel: 'hrm-panel'),
            9 => DocumentResource::getUrl('index', panel: 'document-panel'),
            13 => TripResource::getUrl('index', panel: 'mileage-panel'),
            15 => NewsResource::getUrl('index', panel: 'news'),
            16 => IncomingMailResource::getUrl('index', panel: 'courrier-panel'),
            17 => UserResource::getUrl('index', panel: 'security-panel'),
            40 => ProfileResource::getUrl('index', panel: 'agent-panel'),
            44 => PublicationResource::getUrl('index', panel: 'publication-panel'),
            58 => ActionPstResource::getUrl('index', panel: 'pst-panel'),
            default => null,
        };
    }

    /**
     * Get all modules sorted by name ASC, with migration status resolved.
     *
     * @return Collection<int,Module>
     */
    public static function getAllModules(): Collection
    {
        return Module::query()
            ->whereNotIn('id', self::modules_to_skip)
            ->orderBy('name')
            ->get()
            ->each(function (Module $module): void {
                if ($module->is_external) {
                    $module->migrated = true;

                    return;
                }
                if ($url = self::urlModule($module)) {
                    $module->url = $url;
                    $module->migrated = true;
                } else {
                    $module->migrated = false;
                }
            });
    }
}
