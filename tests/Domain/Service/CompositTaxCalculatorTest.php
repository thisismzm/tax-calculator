<?php
use PHPUnit\Framework\TestCase;
use Mzm\TaxCalculator\Domain\Entity\County;
use Mzm\TaxCalculator\Domain\Service\TaxCalculator;
use Mzm\TaxCalculator\Domain\Contract\TaxableInterface;
use Mzm\TaxCalculator\Domain\Service\CompositeTaxCalculator;

class CompositeTaxCalculatorTest extends TestCase
{
    public function testCalculate()
    {
        // Creating county tax calculator
        $county1 = $this->createMock(TaxableInterface::class);
        $county1->method('getTaxRate')
            ->willReturn(0.1);
        $county1->method('getIncome')
            ->willReturn(1000);
        $countyCalculator1 = new TaxCalculator($county1);

        // Creating county tax calculator
        $county2 = $this->createMock(TaxableInterface::class);
        $county2->method('getTaxRate')
            ->willReturn(0.2);
        $county2->method('getIncome')
            ->willReturn(10000);
        
        $countyCalculator2 = new TaxCalculator($county2);

        // Creating state tax calculator
        $stateCalculator1 = new CompositeTaxCalculator();
        $stateCalculator1->add($countyCalculator1);
        $stateCalculator1->add($countyCalculator2);
        
        $this->assertEquals(2100, $stateCalculator1->calculate());

        // Creating county tax calculator
        $county1 = $this->createMock(TaxableInterface::class);
        $county1->method('getTaxRate')
            ->willReturn(0.1);
        $county1->method('getIncome')
            ->willReturn(2000);
        $countyCalculator1 = new TaxCalculator($county1);

        // Creating county tax calculator
        $county2 = $this->createMock(TaxableInterface::class);
        $county2->method('getTaxRate')
            ->willReturn(0.2);
        $county2->method('getIncome')
            ->willReturn(20000);
        $countyCalculator2 = new TaxCalculator($county2);

        // Creating state tax calculator
        $stateCalculator2 = new CompositeTaxCalculator();
        $stateCalculator2->add($countyCalculator1);
        $stateCalculator2->add($countyCalculator2);

        // Creating county tax calculator
        $countryCalculator = new CompositeTaxCalculator();
        $countryCalculator->add($stateCalculator1);
        $countryCalculator->add($stateCalculator2);
        
        $this->assertEquals(6300, $countryCalculator->calculate());
    }
}
