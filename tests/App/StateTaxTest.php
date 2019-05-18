<?php
use PHPUnit\Framework\TestCase;
use Mzm\TaxCalculator\App\StateTax;
use Mzm\TaxCalculator\Domain\Entity\State;
use Mzm\TaxCalculator\Domain\Entity\County;

class StateTaxTest extends TestCase
{
    public function testGetOverallTax()
    {
        $county1 = $this->createMock(County::class);
        $county1->expects($this->any())
            ->method('getTaxRate')
            ->willReturn(0.1);
        $county1->expects($this->any())
            ->method('getIncome')
            ->willReturn(20000);

        $county2 = $this->createMock(County::class);
        $county2->expects($this->any())
            ->method('getTaxRate')
            ->willReturn(0.2);
        $county2->expects($this->any())
            ->method('getIncome')
            ->willReturn(40000);

        $state = $this->createMock(State::class);
        $state->expects($this->any())
            ->method('getCounties')
            ->willReturn([$county1, $county2]);
        $state->expects($this->any())
            ->method('getIncome')
            ->willReturn(60000);
        
        $stateTax = new StateTax($state);

        $this->assertEquals(10000, $stateTax->getOverallTax());
        $this->assertEquals(0.15, $stateTax->getAverageCountyTaxRate());
    }
}
