<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Resources\Signatures\Pages;

use AcMarche\App\Filament\Resources\Signatures\SignatureResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Override;

final class CreateSignature extends CreateRecord
{
    #[Override]
    protected static string $resource = SignatureResource::class;

    public function getTitle(): string
    {
        return 'Créer ma signature';
    }

    protected function fillForm(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        $this->form->fill([
            'prenom' => $user?->first_name,
            'nom' => $user?->last_name,
            'email' => $user?->email,
            'username' => $user?->username,
            'telephone' => $user?->phone,
            'gsm' => $user?->mobile,
            'code_postal' => 6900,
            'localite' => 'Marche-en-Famenne',
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
