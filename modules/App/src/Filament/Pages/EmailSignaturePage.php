<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Pages;

use AcMarche\Hrm\Filament\Resources\Teleworks\Schemas\TeleworkForm;
use AcMarche\Hrm\Models\Telework as TeleworkModel;
use AcMarche\Hrm\Services\TeleworkNotifier;
use BackedEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Override;

final class EmailSignaturePage extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?TeleworkModel $record = null;

    #[Override]
    protected static string|null|BackedEnum $navigationIcon = Heroicon::OutlinedEnvelope;

    #[Override]
    protected static ?string $navigationLabel = 'Signature email';

    #[Override]
    protected string $view = 'app::filament.pages.email-signature';

    public function getTitle(): string
    {
        return 'Absence de bureau';
    }

    public function mount(): void
    {
        $username = Auth::user()?->username;
        abort_unless($username !== null, 403);

        $this->record = TeleworkModel::query()->where('user_add', $username)->first();

        $this->form->fill($this->record?->toArray() ?? []);
    }

    public function form(Schema $schema): Schema
    {
        return TeleworkForm::configure($schema)->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if ($this->record instanceof TeleworkModel) {
            $this->record->update($data);
        } else {
            $this->record = TeleworkModel::create($data);
            TeleworkNotifier::notifyManagerOfNewRequest($this->record);
        }

        Notification::make()
            ->title('Enregistré')
            ->success()
            ->send();
    }
}
