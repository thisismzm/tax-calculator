<?php

namespace Mzm\TaxCalculator\Domain\Contract;

interface TaxableInterface extends HasIncomeInterface
{
    /**
     * @return float
     */
    public function getTaxRate();
}
