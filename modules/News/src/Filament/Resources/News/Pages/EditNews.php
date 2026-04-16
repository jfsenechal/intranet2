<?php

declare(strict_types=1);

namespace AcMarche\News\Filament\Resources\News\Pages;

use Override;
use Filament\Actions\ViewAction;
use AcMarche\News\Filament\Resources\News\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

final class EditNews extends EditRecord
{
    #[Override]
    protected static string $resource = NewsResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->getRecord()->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon('tabler-eye'),
        ];
    }
}
