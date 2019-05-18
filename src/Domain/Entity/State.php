<?php

namespace Mzm\TaxCalculator\Domain\Entity;

use Mzm\TaxCalculator\Domain\Contract\HasIncomeInterface;

class State extends AbstractEntity implements HasIncomeInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array array of County
     */
    protected $counties;

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
     * Get the value of counties
     *
     * @return array array of County
     */
    public function getCounties()
    {
        return $this->counties;
    }

    /**
     * Set the value of counties
     *
     * @param array array of County
     *
     * @return  self
     */
    public function setCounties(array $counties)
    {
        $this->counties = $counties;

        return $this;
    }

    /**
     * @param County $county
     *
     * @return self
     */
    public function addCounty(County $county)
    {
        $this->counties[] = $county;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIncome()
    {
        return array_reduce(
            $this->counties,
            static function ($income, $county) {
                return $income + $county->getIncome();
            },
            0
        );
    }
}
