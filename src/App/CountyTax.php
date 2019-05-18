<?php

namespace Mzm\TaxCalculator\App;

use Mzm\TaxCalculator\Domain\Entity\County;
use Mzm\TaxCalculator\Domain\Service\TaxCalculator;

final class CountyTax extends TaxCalculator
{
    /**
     * @param County $county
     */
    public function __construct(County $county)
    {
        parent::__construct($county);
    }

    /**
     * Get tax of a county
     *
     * @return float
     */
    public function getTax()
    {
        return $this->calculate();
    }
}
