<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\ContractNatures\Pages;

use Override;
use AcMarche\Hrm\Filament\Resources\ContractNatures\ContractNatureResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateContractNature extends CreateRecord
{
    #[Override]
    protected static string $resource = ContractNatureResource::class;
}
