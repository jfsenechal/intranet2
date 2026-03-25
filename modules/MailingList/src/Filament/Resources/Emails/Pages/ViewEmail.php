<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Emails\Pages;

use AcMarche\MailingList\Enums\EmailStatus;
use AcMarche\MailingList\Filament\Resources\Emails\EmailResource;
use AcMarche\MailingList\Handler\MailerHandler;
use AcMarche\MailingList\Mail\NewsletterMail;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

final class ViewEmail extends ViewRecord
{
    protected static string $resource = EmailResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('subject')
                    ->columnSpanFull(),
                TextEntry::make('sender.name')
                    ->label('Sender'),
                TextEntry::make('sender.email')
                    ->label('Sender Email'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (EmailStatus $state): string => match ($state) {
                        EmailStatus::Draft => 'gray',
                        EmailStatus::Sending => 'warning',
                        EmailStatus::Sent => 'success',
                        EmailStatus::Failed => 'danger',
                    }),
                TextEntry::make('total_count')
                    ->label('Recipients'),
                TextEntry::make('body')
                    ->html()
                    ->prose()
                    ->columnSpanFull(),
                RepeatableEntry::make('recipients')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email_address'),
                        TextEntry::make('status')
                            ->badge(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Apercu')
                ->icon(Heroicon::Eye)
                ->color('warning')
                ->modalHeading('Envoyer un apercu')
                ->schema([
                    TextInput::make('email')
                        ->label('Adresse e-mail')
                        ->email()
                        ->required()
                        ->default(fn (): ?string => auth()->user()?->email),
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
                }),
            Action::make('send')
                ->label('Envoyer')
                ->icon(Heroicon::PaperAirplane)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Envoyer la newsletter')
                ->modalDescription(fn (): string => "Cet e-mail sera envoyé à {$this->record->total_count} destinataires. Continuer ?")
                ->visible(fn (): bool => $this->record->status === EmailStatus::Draft || $this->record->status === EmailStatus::Failed)
                ->action(fn () => MailerHandler::sendEmail($this->record)),
            Action::make('progress')
                ->label(fn (): string => "Envoyé : {$this->record->sent_count}/{$this->record->total_count}")
                ->icon(Heroicon::ChartBar)
                ->color(fn (): string => match ($this->record->status) {
                    EmailStatus::Sending => 'warning',
                    EmailStatus::Sent => 'success',
                    EmailStatus::Failed => 'danger',
                    default => 'gray',
                })
                ->disabled()
                ->visible(fn (): bool => $this->record->status !== EmailStatus::Draft),
            EditAction::make()
                ->label('Modifier')
                ->icon(Heroicon::PencilSquare),
            DeleteAction::make()
                ->label('Supprimer')
                ->icon(Heroicon::Trash),
        ];
    }
}
