<?php

namespace Mzm\TaxCalculator\Domain\Contract;

interface HasIncomeInterface
{
    /**
     * @return float
     */
    public function getIncome();
}
