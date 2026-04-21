<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Profiles\Pages;

use AcMarche\Agent\Filament\Resources\Profiles\ProfileResource;
use AcMarche\Security\Filament\Resources\Users\Schemas\UserForm;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Override;

final class CreateProfile extends CreateRecord
{
    #[Override]
    protected static string $resource = ProfileResource::class;

    protected static ?string $title = 'Ajouter un profil';

    protected static bool $canCreateAnother = false;

    public function form(Schema $schema): Schema
    {
        return UserForm::add($schema);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uuid'] ??= (string) Str::uuid();
        $data['emails'] ??= [];
        $data['modules'] ??= [];

        return $data;
    }
}
