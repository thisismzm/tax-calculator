<?php

namespace Mzm\TaxCalculator\Domain\Contract;

interface TaxCalculatorInterface
{
    /**
     * @return float
     */
    public function calculate();
}
