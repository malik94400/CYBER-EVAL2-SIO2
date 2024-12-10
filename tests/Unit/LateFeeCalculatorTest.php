<?php

namespace App\Tests\Unit;

use App\Service\LateFeeCalculator;
use PHPUnit\Framework\TestCase;

class LateFeeCalculatorTest extends TestCase
{
    public function testCalculateLateFee(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2024-01-04');

        $this->assertEquals(1.5, $calculator->calculateLateFee($dueDate, $returnDate));
    }

    public function testReturnedBeforeDueDate(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2023-12-31');

        $this->assertEquals(0.0, $calculator->calculateLateFee($dueDate, $returnDate));
    }

    public function testReturnedOnDueDate(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2024-01-01');

        $this->assertEquals(0.0, $calculator->calculateLateFee($dueDate, $returnDate));
    }

    public function testReturnedWithThreeDaysLate(): void
    {
        $calculator = new LateFeeCalculator();
        $dueDate = new \DateTime('2024-01-01');
        $returnDate = new \DateTime('2024-01-04');

        $this->assertEquals(1.5, $calculator->calculateLateFee($dueDate, $returnDate));
    }
}
