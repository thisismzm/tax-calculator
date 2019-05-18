<?php

namespace Mzm\TaxCalculator\Domain\Entity;

use Mzm\TaxCalculator\Domain\Contract\HasIncomeInterface;

class Country extends AbstractEntity implements HasIncomeInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array array of State
     */
    protected $states;

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
     * Get the value of states
     *
     * @return array array of State
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Set the value of states
     *
     * @param array array of State
     *
     * @return self
     */
    public function setStates(array $states)
    {
        $this->states = $states;

        return $this;
    }

    /**
     * @param State $state
     *
     * @return self
     */
    public function addState(State $state)
    {
        $this->states[] = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIncome()
    {
        return array_reduce(
            $this->states,
            static function ($income, $state) {
                return $income + $state->getIncome();
            },
            0
        );
    }
}
