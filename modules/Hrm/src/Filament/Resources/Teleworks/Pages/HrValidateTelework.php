<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Teleworks\Pages;

use AcMarche\Hrm\Filament\Resources\Teleworks\TeleworkResource;
use AcMarche\Hrm\Models\Telework;
use AcMarche\Hrm\Services\TeleworkNotifier;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Override;

final class HrValidateTelework extends EditRecord
{
    #[Override]
    protected static string $resource = TeleworkResource::class;

    #[Override]
    protected static ?string $title = 'Traitement GRH';

    public function getTitle(): string|Htmlable
    {
        return 'Traitement GRH - '.$this->record->user_add;
    }

    #[Override]
    public function form(Schema $schema): Schema
    {
        /** @var Telework $telework */
        $telework = $this->record;

        return $schema
            ->columns(1)
            ->components([
                Section::make('Demande')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('user_add')
                            ->label('Agent')
                            ->content($telework->user_add),
                        Placeholder::make('location_type')
                            ->label('Lieu')
                            ->content($telework->location_type?->getLabel()),
                        Placeholder::make('day_type')
                            ->label('Type de jour')
                            ->content($telework->day_type?->getLabel()),
                        Placeholder::make('fixed_day')
                            ->label('Jour fixe')
                            ->content($telework->fixed_day?->getLabel() ?? '-'),
                        Placeholder::make('variable_day_reason')
                            ->label('Motivation jour variable')
                            ->content(new HtmlString((string) $telework->variable_day_reason))
                            ->columnSpanFull(),
                    ]),
                Section::make('Validation du chef')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('manager_validated')
                            ->label('Validée')
                            ->content($telework->manager_validated ? 'Oui' : 'Non'),
                        Placeholder::make('manager_validator_name')
                            ->label('Chef')
                            ->content($telework->manager_validator_name ?? '-'),
                        Placeholder::make('manager_validated_at')
                            ->label('Date')
                            ->content($telework->manager_validated_at?->format('d/m/Y') ?? '-'),
                        Placeholder::make('manager_validation_notes')
                            ->label('Notes du chef')
                            ->content(new HtmlString((string) $telework->manager_validation_notes))
                            ->columnSpanFull(),
                    ]),
                Section::make('GRH')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('date_college')
                            ->label('Date collège'),
                        TextInput::make('hr_validator_name')
                            ->label('Votre nom')
                            ->default(fn () => Auth::user()?->full_name)
                            ->maxLength(100)
                            ->required(),
                        RichEditor::make('hr_notes')
                            ->label('Notes GRH')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected function afterSave(): void
    {
        /** @var Telework $telework */
        $telework = $this->record;

        TeleworkNotifier::notifyEmployeeAfterHrValidation($telework);

        Notification::make()
            ->title('Traitement enregistré et agent notifié')
            ->success()
            ->send();
    }

    #[Override]
    protected function getSavedNotificationTitle(): ?string
    {
        return null;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Enregistrer'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Retour à la demande')
                ->url(fn () => ViewTelework::getUrl(['record' => $this->record])),
        ];
    }
}
