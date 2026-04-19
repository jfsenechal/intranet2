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
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Override;

final class ManagerValidateTelework extends EditRecord
{
    #[Override]
    protected static string $resource = TeleworkResource::class;

    #[Override]
    protected static ?string $title = 'Validation du chef';

    public function getTitle(): string|Htmlable
    {
        return 'Validation du chef - '.$this->record->user_add;
    }

    #[Override]
    public function form(Schema $schema): Schema
    {
        /** @var Telework $telework */
        $telework = $this->record;

        return $schema
            ->columns(1)
            ->components([
                Section::make('Demande de l\'agent')
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
                        Placeholder::make('employee_notes')
                            ->label('Remarques de l\'agent')
                            ->content(new HtmlString((string) $telework->employee_notes))
                            ->columnSpanFull(),
                    ]),
                Section::make('Décision')
                    ->columns(2)
                    ->schema([
                        Toggle::make('manager_validated')
                            ->label('Je valide cette demande'),
                        DatePicker::make('manager_validated_at')
                            ->label('Date de validation')
                            ->default(Carbon::today())
                            ->required(),
                        TextInput::make('manager_validator_name')
                            ->label('Votre nom')
                            ->default(fn () => Auth::user()?->full_name)
                            ->maxLength(100)
                            ->required(),
                        RichEditor::make('manager_validation_notes')
                            ->label('Notes / motivation')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected function afterSave(): void
    {
        /** @var Telework $telework */
        $telework = $this->record;

        TeleworkNotifier::notifyEmployeeAfterManagerValidation($telework);

        if ($telework->manager_validated) {
            TeleworkNotifier::notifyHrTeam($telework);
        }

        Notification::make()
            ->title('Validation enregistrée et notifications envoyées')
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
            $this->getSaveFormAction()->label('Enregistrer la validation'),
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
