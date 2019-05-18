<?php

namespace Mzm\TaxCalculator\App;

use Mzm\TaxCalculator\Domain\Service\CompositeTaxCalculator;
use Mzm\TaxCalculator\Domain\Entity\State;
use Mzm\TaxCalculator\Domain\Service\TaxCalculator;

final class StateTax extends CompositeTaxCalculator
{
    /**
     * @var State
     */
    private $state;

    /**
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->state = $state;
        foreach ($state->getCounties() as $county) {
            $this->add(new TaxCalculator($county));
        }
    }

    /**
     * Output the overall amount of taxes collected per state
     *
     * @return float
     */
    public function getOverallTax()
    {
        return $this->calculate();
    }

    /**
     * Output the average county tax rate per state
     *
     * @return float
     */
    public function getAverageCountyTaxRate()
    {
        $taxRatesTotal = array_reduce(
            $this->state->getCounties(),
            static function ($totalTaxRate, $county) {
                return $totalTaxRate + $county->getTaxRate();
            },
            0
        );
        return $taxRatesTotal / count($this->state->getCounties());
    }
}
