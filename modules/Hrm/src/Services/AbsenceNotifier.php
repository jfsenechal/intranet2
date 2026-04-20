<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Services;

use AcMarche\Hrm\Models\Absence;

final class AbsenceNotifier
{
    private function checkProximityAlert(Absence $absence): void
    {
        $alert = $this->getProximityAlert($absence);
        if ($alert) {
            $this->addFlash('warning', $alert);
        }
    }

    private function getProximityAlert(Absence $absence): ?string
    {
        $previousAbsence = $this->absenceRepository->findPreviousAbsence($absence);
        if (! $previousAbsence || ! $previousAbsence->getDateFin() || ! $absence->getDateFin()) {
            return null;
        }

        $diffDays = $previousAbsence->getDateFin()->diff($absence->getDateFin())->days;
        $eightWeeksInDays = 8 * 7;

        if ($diffDays <= $eightWeeksInDays) {
            $weeks = intdiv($diffDays, 7);
            $days = $diffDays % 7;

            return sprintf(
                'Attention : cette absence est enregistrée %d semaine(s) et %d jour(s) après la précédente (du %s). Délai inférieur à 8 semaines.',
                $weeks,
                $days,
                $previousAbsence->getDateFin()->format('d-m-Y'),
            );
        }

        return null;
    }
}
