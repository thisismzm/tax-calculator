<?php
use PHPUnit\Framework\TestCase;
use Mzm\TaxCalculator\Domain\Service\TaxCalculator;
use Mzm\TaxCalculator\Domain\Contract\TaxableInterface;

class TaxCalculatorTest extends TestCase
{
    public function testCalculate()
    {
        $taxable = $this->createMock(TaxableInterface::class);
        $taxable->method('getTaxRate')
            ->willReturn(0.1);
        $taxable->method('getIncome')
            ->willReturn(1000);
        
        $calculator = new TaxCalculator($taxable);

        $this->assertEquals(100, $calculator->calculate());
    }
}
