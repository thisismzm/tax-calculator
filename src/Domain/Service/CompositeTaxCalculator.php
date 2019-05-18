<?php

namespace Mzm\TaxCalculator\Domain\Service;

use Mzm\TaxCalculator\Domain\Contract\TaxCalculatorInterface;

class CompositeTaxCalculator implements TaxCalculatorInterface
{
    /**
     * @var array TaxCalculatorInterface[]
     */
    protected $calculators;

    /**
     * @return float
     */
    public function calculate()
    {
        return array_reduce(
            $this->calculators,
            static function ($tax, TaxCalculatorInterface $taxCalculator) {
                return $tax + $taxCalculator->calculate();
            },
            0
        );
    }

    /**
     * @param TaxCalculatorInterface $calculator
     */
    public function add(TaxCalculatorInterface $calculator)
    {
        $this->calculators[] = $calculator;
    }

    /**
     * @param TaxCalculatorInterface $calculator
     */
    public function remove(TaxCalculatorInterface $calculator)
    {
        $this->calculators = array_filter(
            $this->calculators,
            static function ($item) use ($calculator) {
                return $item !== $calculator;
            }
        );
    }

    /**
     * Get the value of countiesCalculator
     *
     * @return array TaxCalculatorInterface[]
     */
    public function getCalculators()
    {
        return $this->calculators;
    }
}
