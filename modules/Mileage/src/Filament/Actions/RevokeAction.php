<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Actions;

use AcMarche\Mileage\Models\PersonalInformation;
use AcMarche\Mileage\Providers\MileageServiceProvider;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

final class RevokeAction
{
    public static function make(): Action
    {
        return Action::make('revoke')
            ->label('Révoquer')
            ->icon(Heroicon::UserMinus)
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading('Révoquer l\'accès')
            ->modalDescription('Êtes-vous sûr de vouloir révoquer l\'accès de cet agent au module déplacements ? Ses rôles et données personnelles seront supprimés.')
            ->action(function (User $record): void {
                $record->roles()
                    ->where('module_id', MileageServiceProvider::$module_id)
                    ->detach();

                PersonalInformation::where('username', $record->username)->delete();
            });
    }
}
