<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\Emails\Pages;

use AcMarche\MailingList\Enums\EmailStatus;
use AcMarche\MailingList\Filament\Actions\PreviewAction;
use AcMarche\MailingList\Filament\Actions\SendAction;
use AcMarche\MailingList\Filament\Resources\Emails\EmailResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

final class ViewEmail extends ViewRecord
{
    protected static string $resource = EmailResource::class;

    public function getTitle(): string
    {
        return $this->record->subject;
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sender.name')
                    ->label('Expéditeur'),
                TextEntry::make('sender.email')
                    ->label('Expéditeur Email'),
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
            PreviewAction::make(),
            SendAction::make($this->record),
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
