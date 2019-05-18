<?php

namespace Mzm\TaxCalculator\Domain\Entity;

use Mzm\TaxCalculator\Domain\Contract\TaxableInterface;

class County extends AbstractEntity implements TaxableInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $taxRate;

    /**
     * @var float
     */
    protected $income;

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of taxRate
     *
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * Set the value of taxRate
     *
     * @param float $taxRate
     *
     * @return  self
     */
    public function setTaxRate(float $taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * Get the value of income
     *
     * @return float
     */
    public function getIncome()
    {
        return $this->income;
    }

    /**
     * Set the value of income
     *
     * @param float $income
     *
     * @return self
     */
    public function setIncome(float $income)
    {
        $this->income = $income;

        return $this;
    }
}
