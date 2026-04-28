<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Console\Commands;

use AcMarche\Hrm\Models\Employer;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SfCommand;

final class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hrm:reminders {department}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all reminders';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        /**
         * 1. Get all recoreds with criteria
         * 2. Change subject by reminder
         * 3. I body email add a link to the record
         * 4. Send email to right department
         */


        /**
         * Absences
         *  ->andWhere('absence.date_rappel = :today')
         *  and where an employee with at least 1 active contract
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * Deadlines
         *  ->andWhere('echeance.date_rappel = :today')
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * Contracts
         *  ->andWhere('contrat.date_rappel = :today')
         *  and where an employee with at least 1 active contract
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * Empoyees as StatusEnum::student
         *
         * $qb->andWhere('employe.statut = :statut')
         * ->setParameter('statut', Statuts::STUDENT);
         *  ->andWhere('employe.date_rappel = :today')
         *  and where an employee with at least 1 active contract
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * Evaluation
         *  ->andWhere('evaluation.date_prochaine = :today')
         *
         * $qb->andWhere('employe.statut = :statut')
         * ->setParameter('statut', Statuts::AGENT);
         *  and where an employee with at least 1 active contract
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * Evolution
         *  ->andWhere('employe.date_rappel = :today')
         *
         * $qb->andWhere('employe.statut = :statut')
         * ->setParameter('statut', Statuts::AGENT);
         *  and where an employee with at least 1 active contract
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * Formation
         *  ->andWhere('formation.date_rappel = :today')
         *  and where an employee with at least 1 active contract
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        /**
         * SmsReminder
         *  ->andWhere('sms.date_rappel = :today')
         *  ->andWhere('sms.date_rappel_other = :today')
         *  and where an employee with at least 1 active contract
         *  add result send
         *   $sms->result =
         */

        /**
         * Stage
         *  ->andWhere('stage.date_rappel = :today')
         * $qb->andWhere('employe.archive != 1');
         *  andWhere(            'contrats.employeur IN (:employeurs)'        )
         * ->setParameter('employeurs', $employeurs);
         */

        return SfCommand::SUCCESS;
    }

    /**
     * @return Employer[]
     */
    public function getEmployeursByDepartement(string $employeurString): array
    {
        $employeur = $this->findOneBy([
            'slugname' => 'cpas',
        ]);
        $qb = $this->createQueryBuilder('employeur')
            ->andWhere('employeur.parent = :id')
            ->setParameter('id', $employeur->getId())
            ->orWhere('employeur.id = :id')
            ->setParameter('id', $employeur->getId());

        $qb->orderBy('employeur.nom');

        return $qb->getQuery()->getResult();
    }

    private function getEmployees(): array
    {
        $departement = $input->getArgument('departement');
        $employeursCpas = $this->getEmployeursByDepartement($departement);
        $employeursVille = $this->getEmployeursByDepartement($departement);

        switch ($departement) {
            case 'ville':
                $this->to = $this->parameterBag->get('grh.rappel.to'); // create a config
                $this->employeurs = $employeursVille;
                break;
            case 'cpas':
                $this->to = $this->parameterBag->get('cpas.rappel.to'); // create a config
                $this->employeurs = $employeursCpas;
                break;
            default:
                $this->to = $this->parameterBag->get('grh.rappel.to');
                $this->employeurs = [];
                break;
        }
    }
}
