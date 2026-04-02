<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Filament\Resources\Users\Pages;

use AcMarche\Mileage\Filament\Resources\Users\UserResource;
use AcMarche\Mileage\Service\PersonalInformationService;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

final class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return 'Ajouter un agent';
    }

    /**
     * Find the existing user by username instead of inserting a new row.
     * This page enrolls an existing user into the mileage module.
     */
    protected function handleRecordCreation(array $data): Model
    {
        return User::where('username', $data['username'])->firstOrFail();
    }

    /**
     * Create PersonalInformation after enrolling a user in the mileage system.
     */
    protected function afterCreate(): void
    {
        /** @var User $user */
        $user = $this->record;

        try {
            PersonalInformationService::createPersonalInformation($user, $this->data);
        } catch (Exception $e) {
            Notification::make()
                ->warning()
                ->title('Les données personnelles sont manquantes')
                ->body($e->getMessage())
                ->persistent()
                ->send();
        }
    }
}
