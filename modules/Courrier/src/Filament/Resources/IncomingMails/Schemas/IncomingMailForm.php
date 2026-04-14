<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\IncomingMails\Schemas;

use AcMarche\Courrier\Repository\RecipientRepository;
use AcMarche\Courrier\Repository\ServiceRepository;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

final class IncomingMailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(self::getComponents());
    }

    /**
     * @param  array<string, mixed>|null  $imapPreview  IMAP preview context: ['url', 'contentType', 'filename']
     */
    public static function getComponents(?array $imapPreview = null): array
    {
        $components = [];

        if ($imapPreview !== null) {
            // IMAP flow: show preview from IMAP server
            $contentType = $imapPreview['contentType'] ?? '';
            $isPreviewable = str_starts_with($contentType, 'image/')
                || $contentType === 'application/pdf';

            if ($isPreviewable) {
                $components[] = Section::make('Aperçu')
                    ->schema([
                        View::make('courrier::components.attachment-preview')
                            ->viewData([
                                'url' => $imapPreview['url'],
                                'contentType' => $contentType,
                                'filename' => $imapPreview['filename'] ?? '',
                            ]),
                    ])
                    ->collapsible();
            }
        } else {
            // Manual flow: file upload with client-side preview
            $components[] = Section::make('Pièce jointe')
                ->schema([
                    FileUpload::make('attachment_file')
                        ->label('Fichier')
                        ->required()
                        ->acceptedFileTypes(config('courrier.allowed_mime_types'))
                        ->maxSize(config('courrier.max_file_size'))
                        ->storeFiles(false)
                        ->previewable(false),
                    View::make('courrier::components.upload-preview'),
                ]);
        }

        // Add the form
        $components[] = Flex::make([
            Section::make('Informations du courrier')
                ->schema([
                    TextInput::make('reference_number')
                        ->label('Numéro')
                        ->required()
                        ->maxLength(255),
                    DatePicker::make('mail_date')
                        ->label('Date du courrier')
                        ->required()
                        ->default(now())
                        ->native(false),
                    TextInput::make('sender')
                        ->label('Expéditeur')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpan(2),
            Section::make('Options')
                ->schema([
                    Toggle::make('is_registered')
                        ->label('Recommandé')
                        ->default(false),
                    Toggle::make('has_acknowledgment')
                        ->label('Accusé de réception')
                        ->default(false),
                ])
                ->grow(false),
        ])->from('md');

        // Add services and recipients
        $components[] = Section::make('Affectation')
            ->schema([
                Select::make('primary_services')
                    ->label('Services principaux')
                    ->options(ServiceRepository::findAllActiveOrdered())
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Select::make('secondary_services')
                    ->label('Services secondaires')
                    ->options(ServiceRepository::findAllActiveOrdered())
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Select::make('primary_recipients')
                    ->label('Destinataires principaux')
                    ->options(RecipientRepository::getActiveForOptions())
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Select::make('secondary_recipients')
                    ->label('Destinataires secondaires')
                    ->options(RecipientRepository::getActiveForOptions())
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->columns(2);

        return $components;
    }
}
