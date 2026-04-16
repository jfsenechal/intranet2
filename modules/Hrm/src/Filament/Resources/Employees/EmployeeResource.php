<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Employees;

use AcMarche\Hrm\Filament\Resources\Employees\Pages\CreateEmployee;
use AcMarche\Hrm\Filament\Resources\Employees\Pages\EditEmployee;
use AcMarche\Hrm\Filament\Resources\Employees\Pages\ListEmployees;
use AcMarche\Hrm\Filament\Resources\Employees\Pages\ViewEmployee;
use AcMarche\Hrm\Filament\Resources\Employees\Schemas\EmployeeForm;
use AcMarche\Hrm\Filament\Resources\Employees\Schemas\EmployeeInfolist;
use AcMarche\Hrm\Filament\Resources\Employees\Tables\EmployeeTables;
use AcMarche\Hrm\Models\Employee;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class EmployeeResource extends Resource
{
    #[Override]
    protected static ?string $model = Employee::class;

    #[Override]
    protected static string|null|UnitEnum $navigationGroup = 'Personnel';

    #[Override]
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationLabel(): string
    {
        return 'Agents';
    }

    public static function getModelLabel(): string
    {
        return 'Agent';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Agents';
    }

    public static function form(Schema $schema): Schema
    {
        return EmployeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmployeeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeTables::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployee::route('/create'),
            'view' => ViewEmployee::route('/{record}/view'),
            'edit' => EditEmployee::route('/{record}/edit'),
        ];
    }
}
