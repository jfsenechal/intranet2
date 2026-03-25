<?php

namespace AcMarche\MailingList\Filament\Actions;

use AcMarche\MailingList\Mail\NewsletterMail;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class PreviewAction
{
    public static function make(): Action
    {
        return Action::make('preview')
            ->label('Apercu')
            ->icon(Heroicon::Eye)
            ->color('warning')
            ->modalHeading('Envoyer un apercu')
            ->schema([
                TextInput::make('email')
                    ->label('Adresse e-mail')
                    ->email()
                    ->required()
                    ->default(fn(): ?string => auth()->user()?->email),
            ])
            ->action(function (array $data): void {
                $this->record->load('sender');

                Mail::to($data['email'])
                    ->send(new NewsletterMail($this->record, 'Apercu'));

                Notification::make()
                    ->title('Apercu envoyé')
                    ->body("Un e-mail de test a été envoyé à {$data['email']}.")
                    ->success()
                    ->send();
            });

    }

}
