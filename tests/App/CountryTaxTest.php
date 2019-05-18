<?php
use PHPUnit\Framework\TestCase;
use Mzm\TaxCalculator\App\CountryTax;
use Mzm\TaxCalculator\Domain\Entity\State;
use Mzm\TaxCalculator\Domain\Entity\County;
use Mzm\TaxCalculator\Domain\Entity\Country;

class CountryTaxTest extends TestCase
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
            ->willReturn(0.1);
        $county2->expects($this->any())
            ->method('getIncome')
            ->willReturn(10000);

        $state1 = $this->createMock(State::class);
        $state1->expects($this->any())
            ->method('getCounties')
            ->willReturn([$county1, $county2]);
        $state1->expects($this->any())
            ->method('getIncome')
            ->willReturn(30000);

        $county3 = $this->createMock(County::class);
        $county3->expects($this->any())
            ->method('getTaxRate')
            ->willReturn(0.2);
        $county3->expects($this->any())
            ->method('getIncome')
            ->willReturn(40000);

        $county4 = $this->createMock(County::class);
        $county4->expects($this->any())
            ->method('getTaxRate')
            ->willReturn(0.1);
        $county4->expects($this->any())
            ->method('getIncome')
            ->willReturn(30000);

        $state2 = $this->createMock(State::class);
        $state2->expects($this->any())
            ->method('getCounties')
            ->willReturn([$county3, $county4]);
        $state2->expects($this->any())
            ->method('getIncome')
            ->willReturn(70000);
        
        $country = $this->createMock(Country::class);
        $country->expects($this->any())
            ->method('getStates')
            ->willReturn([$state1, $state2]);
        $country->expects($this->any())
            ->method('getIncome')
            ->willReturn(100000);

        $countryTax = new CountryTax($country);
        
        $this->assertEquals(14000, $countryTax->getOverallTax());
        $this->assertEquals(0.14, $countryTax->getAverageTaxRate());
        $this->assertEquals(7000, $countryTax->getAverageTaxPerState());
    }
}
