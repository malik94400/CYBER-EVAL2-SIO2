<?php

namespace App\Tests\Unit;

use App\Service\LateFeeCalculator;
use PHPUnit\Framework\TestCase;

class LateFeeCalculatorTest extends TestCase
{
    public function testCalculerFraisRetard(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2024-01-04');

        $this->assertEquals(1.5, $calculator->calculateLateFee($dueDate, $returnDate));
    }

    public function testRetourneAvantDateEcheance(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2023-12-31');

        $this->assertEquals(0.0, $calculator->calculateLateFee($dueDate, $returnDate));
    }

    public function testRetourneLeJourDeDateEcheance(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2024-01-01');

        $this->assertEquals(0.0, $calculator->calculateLateFee($dueDate, $returnDate));
    }

    public function testRetourneAvecTroisJoursDeRetard(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2024-01-04');

        $this->assertEquals(1.5, $calculator->calculateLateFee($dueDate, $returnDate));
    }
}
