<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Console\Commands;

use AcMarche\Hrm\Models\Absence;
use Illuminate\Console\Command;
use Override;

final class MigrationCommand extends Command
{
    #[Override]
    protected $signature = 'hrm:migration';

    #[Override]
    protected $description = 'Migraton';

    public function handle(): int
    {
        /**
         * absences set true for oui false for non
         * for properties :
         * 'certimed' => 'boolean',
         * 'has_resumed' => 'boolean',
         * 'clock_updated' => 'boolean',
         * 'acropole' => 'boolean',
         * 'agent_file' => 'boolean',
         *
         * create a migration to change the type of these properties
         */
        foreach (Absence::all() as $absence) {

        }

        $this->info('Merge completed successfully!');
        $this->displaySummary();

        return self::SUCCESS;
    }
}
