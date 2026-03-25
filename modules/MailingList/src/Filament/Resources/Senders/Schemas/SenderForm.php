<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Senders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class SenderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(255)
                    ->required(),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('mailing-list/senders/logos')
                    ->visibility('public')
                    ->automaticallyResizeImagesMode('cover')
                    ->imageAspectRatio('16:9')
                    ->automaticallyResizeImagesToWidth('300')
                    ->columnSpanFull(),
                RichEditor::make('footer')
                    ->label('Pied de page')
                    ->columnSpanFull(),
                Hidden::make('username')
                    ->default(fn (): ?string => auth()->user()?->username),
            ]);
    }
}
