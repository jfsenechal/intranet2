<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Console\Commands;

use AcMarche\Hrm\Models\Employee;
use AcMarche\Security\Ldap\UserLdap;
use Illuminate\Console\Command;
use LdapRecord\Models\Model;
use Override;
use Symfony\Component\Console\Command\Command as SfCommand;

final class SyncEmployeeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    #[Override]
    protected $signature = 'hrm:sync-employees';

    /**
     * The console command description.
     *
     * @var string
     */
    #[Override]
    protected $description = 'Sync employees with ldap';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        foreach (Employee::query()->whereHas('employees.username') as $employee) {
            $model = UserLdap::findByUsername($employee->username);
            if (!$model instanceof Model) {
                //$employee->setUsername(null);
                $employee->email_professionnel = null;
                $employee->mobile_professionnel = null;
                $employee->telephone_professionnel = null;
                $employee->telephone_extension_professionnel = null;
            } else {
                $employee->email_professionnel = $model->getFirstAttribute('mail');
                $employee->mobile_professionnel = $model->getFirstAttribute('mobile');
                $employee->telephone_professionnel = $model->getFirstAttribute('telephoneNumber');
                $employee->telephone_extension_professionnel = $model->getFirstAttribute('ipPhone');
            }
        }

        return SfCommand::SUCCESS;
    }
}
