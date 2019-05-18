<?php
use PHPUnit\Framework\TestCase;
use Mzm\TaxCalculator\App\CountyTax;
use Mzm\TaxCalculator\Domain\Entity\County;

class CountyTaxTest extends TestCase
{
    public function testGetTax()
    {
        $county = $this->createMock(County::class);
        $county->expects($this->any())
            ->method('getTaxRate')
            ->willReturn(0.1);
        $county->expects($this->any())
            ->method('getIncome')
            ->willReturn(1000);
        
        $countyTax = new CountyTax($county);

        $this->assertEquals(100, $countyTax->getTax());
    }
}
