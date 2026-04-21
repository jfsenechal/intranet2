<?php

declare(strict_types=1);

namespace AcMarche\Agent\Filament\Resources\Agents;

use AcMarche\Agent\Filament\Resources\Agents\Pages\CreateAgent;
use AcMarche\Agent\Filament\Resources\Agents\Pages\EditAgent;
use AcMarche\Agent\Filament\Resources\Agents\Pages\ListAgents;
use AcMarche\Agent\Filament\Resources\Agents\Pages\ViewAgent;
use AcMarche\Agent\Filament\Resources\Agents\RelationManagers\ExternalApplicationsRelationManager;
use AcMarche\Agent\Filament\Resources\Agents\RelationManagers\FoldersRelationManager;
use AcMarche\Agent\Filament\Resources\Agents\RelationManagers\HistoriesRelationManager;
use AcMarche\Agent\Filament\Resources\Agents\RelationManagers\SharesRelationManager;
use AcMarche\Agent\Filament\Resources\Agents\Schemas\AgentForm;
use AcMarche\Agent\Filament\Resources\Agents\Schemas\AgentInfolist;
use AcMarche\Agent\Filament\Resources\Agents\Tables\AgentTables;
use AcMarche\Agent\Models\Agent;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Override;

final class AgentResource extends Resource
{
    #[Override]
    protected static ?string $model = Agent::class;

    #[Override]
    protected static ?int $navigationSort = 1;

    #[Override]
    protected static ?string $recordTitleAttribute = 'last_name';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-identification';
    }

    public static function getNavigationLabel(): string
    {
        return 'Agents';
    }

    public static function getModelLabel(): string
    {
        return 'agent';
    }

    public static function getPluralModelLabel(): string
    {
        return 'agents';
    }

    public static function form(Schema $schema): Schema
    {
        return AgentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AgentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgentTables::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ExternalApplicationsRelationManager::class,
            FoldersRelationManager::class,
            SharesRelationManager::class,
            HistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAgents::route('/'),
            'create' => CreateAgent::route('/create'),
            'view' => ViewAgent::route('/{record}'),
            'edit' => EditAgent::route('/{record}/edit'),
        ];
    }
}
