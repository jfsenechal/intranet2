<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees\Pages;

use AcMarche\Hrm\Filament\Resources\Absences\AbsenceResource;
use AcMarche\Hrm\Filament\Resources\Contracts\ContractResource;
use AcMarche\Hrm\Filament\Resources\Deadlines\DeadlineResource;
use AcMarche\Hrm\Filament\Resources\Diplomas\DiplomaResource;
use AcMarche\Hrm\Filament\Resources\Employees\EmployeeResource;
use AcMarche\Hrm\Filament\Resources\HrDocuments\Schemas\HrDocumentForm;
use AcMarche\Hrm\Filament\Resources\Trainings\TrainingResource;
use AcMarche\Hrm\Filament\Resources\Valorizations\ValorizationResource;
use AcMarche\Hrm\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;
use Override;

final class ViewEmployee extends ViewRecord
{
    #[Override]
    protected static string $resource = EmployeeResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->record->last_name.' '.$this->record->first_name;
    }

    protected function getHeaderActions(): array
    {
        $employeeId = ['employee_id' => $this->record->id];

        return [
            EditAction::make()
                ->icon(Heroicon::Pencil),
            ActionGroup::make([
                Action::make('addAbsence')
                    ->label('Ajouter une absence')
                    ->icon('tabler-plus')
                    ->url(AbsenceResource::getUrl('create', $employeeId)),
                Action::make('addDeadline')
                    ->label('Ajouter une échéance')
                    ->icon('tabler-plus')
                    ->url(DeadlineResource::getUrl('create', $employeeId)),
                Action::make('addContract')
                    ->label('Ajouter un contrat')
                    ->icon('tabler-plus')
                    ->url(ContractResource::getUrl('create', $employeeId)),
                Action::make('addTraining')
                    ->label('Ajouter une formation')
                    ->icon('tabler-plus')
                    ->url(TrainingResource::getUrl('create', $employeeId)),
                Action::make('addDocument')
                    ->label('Ajouter un document')
                    ->icon('tabler-plus')
                    ->modalHeading('Ajouter un document')
                    ->schema(HrDocumentForm::getSchema())
                    ->action(function (array $data, Employee $record): void {
                        $path = $data['file_name'] ?? null;
                        $record->documents()->create([
                            'name' => $data['name'],
                            'file_name' => $path,
                            'mime' => $path ? (Storage::disk('public')->mimeType($path) ?: '') : '',
                            'notes' => $data['notes'] ?? null,
                        ]);
                    })
                    ->successNotificationTitle('Document ajouté'),
                Action::make('addDiploma')
                    ->label('Ajouter un diplôme')
                    ->icon('tabler-plus')
                    ->url(DiplomaResource::getUrl('create', $employeeId)),
                Action::make('addValorization')
                    ->label('Ajouter une valorisation')
                    ->icon('tabler-plus')
                    ->url(ValorizationResource::getUrl('create', $employeeId)),
            ])
                ->label('Ajouter...')
                ->color('warning')
                ->icon('tabler-plus')
                ->button(),
            DeleteAction::make()
                ->icon(Heroicon::Trash),
        ];
    }
}
