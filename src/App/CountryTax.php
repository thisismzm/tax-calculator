<?php

namespace Mzm\TaxCalculator\App;

use Mzm\TaxCalculator\Domain\Service\CompositeTaxCalculator;
use Mzm\TaxCalculator\Domain\Service\TaxCalculator;
use Mzm\TaxCalculator\Domain\Entity\Country;

final class CountryTax extends CompositeTaxCalculator
{
    /**
     * @var Country
     */
    private $country;

    /**
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        $this->country = $country;
        foreach ($country->getStates() as $state) {
            $ctc = new CompositeTaxCalculator();
            foreach ($state->getCounties() as $county) {
                $ctc->add(new TaxCalculator($county));
            }
            $this->add($ctc);
        }
    }

    /**
     * Output the collected overall taxes of the country
     *
     * @return float
     */
    public function getOverallTax()
    {
        return $this->calculate();
    }

    /**
     * Output the average amount of taxes collected per state
     *
     * @return float
     */
    public function getAverageTaxPerState()
    {
        return $this->getOverallTax() / count($this->country->getStates());
    }

    /**
     * Output the average tax rate of the country
     *
     * @return float
     */
    public function getAverageTaxRate()
    {
        return $this->getOverallTax() / $this->country->getIncome();
    }
}
