<?php

namespace Mzm\TaxCalculator\Domain\Service;

use Mzm\TaxCalculator\Domain\Contract\TaxCalculatorInterface;
use Mzm\TaxCalculator\Domain\Contract\TaxableInterface;

class TaxCalculator implements TaxCalculatorInterface
{
    /**
     * @var TaxableInterface
     */
    protected $taxable;

    /**
     * @param TaxableInterface $taxable
     */
    public function __construct(TaxableInterface $taxable)
    {
        $this->taxable = $taxable;
    }

    /**
     * @return float
     */
    public function calculate()
    {
        return $this->taxable->getIncome() * $this->taxable->getTaxRate();
    }
}
