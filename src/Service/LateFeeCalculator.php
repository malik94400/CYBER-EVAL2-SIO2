<?php

namespace App\Service;

use DateTime;

class LateFeeCalculator
{
    private const FEE_PER_DAY = 0.5; // 0,50 € par jour de retard

    public function calculateLateFee(DateTime $dueDate, DateTime $returnDate): float
    {
        // Si le livre est retourné avant la date d'échéance ou le jour même
        if ($returnDate <= $dueDate) {
            return 0.0;
        }

        // Calcul du nombre de jours de retard
        $interval = $dueDate->diff($returnDate);
        $daysLate = $interval->days;

        // Calcul des frais de retard
        return $daysLate * self::FEE_PER_DAY;
    }
}