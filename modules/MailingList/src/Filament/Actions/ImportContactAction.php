<?php

namespace AcMarche\MailingList\Filament\Actions;

use AcMarche\MailingList\Filament\Imports\ContactImporter;
use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Support\Icons\Heroicon;

class ImportContactAction
{
    public static function make(): Action
    {
        return
            ImportAction::make()
                ->importer(ContactImporter::class)
                ->label('Importer des contacts')
                ->modalDescription('Le séparateur de champ est la virgule (",").')
                ->icon(Heroicon::ArrowUpTray)
                ->csvDelimiter(',');
    }
}
