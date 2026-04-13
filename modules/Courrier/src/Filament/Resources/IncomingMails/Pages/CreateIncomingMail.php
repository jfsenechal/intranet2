<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\IncomingMails\Pages;

use AcMarche\Courrier\Filament\Resources\IncomingMails\IncomingMailResource;
use AcMarche\Courrier\Models\Attachment;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

final class CreateIncomingMail extends CreateRecord
{
    protected static string $resource = IncomingMailResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return 'Ajouter un courrier';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['attachment_file']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $file = $this->data['attachment_file'] ?? null;

        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        $originalName = $file->getClientOriginalName();
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $storedFilename = sprintf(
            '%d_%s.%s',
            $this->record->id,
            Str::slug(pathinfo($originalName, PATHINFO_FILENAME)),
            $extension
        );

        $path = "courrier/attachments/{$storedFilename}";
        Storage::disk('local')->put($path, $file->readStream());

        Attachment::create([
            'incoming_mail_id' => $this->record->id,
            'file_name' => $storedFilename,
            'mime' => $file->getMimeType(),
        ]);
    }
}
