<?php
define('DS', DIRECTORY_SEPARATOR);
require(__DIR__ . DS . 'vendor' . DS . 'autoload.php');
$data = [
    'countries' => [
        [
            'id' => uniqid('country_', true),
            'name' => 'Country 1',
            'states' => [
                [
                    'id' => uniqid('state_', true),
                    'name' => 'State 1-1',
                    'counties' => [
                        [
                            'id' => uniqid('county_', true),
                            'name' => 'County 1-1-1',
                            'taxRate' => 0.08,
                            'income' => 100000,
                        ], [
                            'id' => uniqid('county_', true),
                            'name' => 'County 1-1-2',
                            'taxRate' => 0.2,
                            'income' => 200000,
                        ],
                    ],
                ],
            ],
        ], [
            'id' => uniqid('country_', true),
            'name' => 'Country 2',
            'states' => [
                [
                    'id' => uniqid('state_', true),
                    'name' => 'State 2-1',
                    'counties' => [
                        [
                            'id' => uniqid('county_', true),
                            'name' => 'County 2-1-1',
                            'taxRate' => 0.04,
                            'income' => 1800000,
                        ], [
                            'id' => uniqid('county_', true),
                            'name' => 'County 2-1-2',
                            'taxRate' => 0.22,
                            'income' => 201000,
                        ],
                    ],
                ],
                [
                    'id' => uniqid('state_', true),
                    'name' => 'State 2-2',
                    'counties' => [
                        [
                            'id' => uniqid('county_', true),
                            'name' => 'County 2-2-1',
                            'taxRate' => 0.13,
                            'income' => 1130000,
                        ], [
                            'id' => uniqid('county_', true),
                            'name' => 'County 2-2-2',
                            'taxRate' => 0.3,
                            'income' => 2394000,
                        ],
                    ],
                ],
            ],
        ],
    ],
];

$countries = [];
foreach ($data['countries'] as $countryData) {
    $country = new \Mzm\TaxCalculator\Domain\Entity\Country();
    $country
        ->setId($countryData['id'])
        ->setName($countryData['name']);
    $states = $countryData['states'];
    foreach ($countryData['states'] as $stateData) {
        $state = new \Mzm\TaxCalculator\Domain\Entity\State();
        $state
            ->setId($stateData['id'])
            ->setName($stateData['name']);
        $counties = $stateData['counties'];
        foreach ($stateData['counties'] as $countyData) {
            $county = new \Mzm\TaxCalculator\Domain\Entity\County();
            $county
                ->setId($countyData['id'])
                ->setName($countyData['name'])
                ->setTaxRate($countyData['taxRate'])
                ->setIncome($countyData['income']);
            $state->addCounty($county);
        }
        $country->addState($state);
    }
    $countries[] = $country;
}

foreach ($countries as $country) {
    $countryTax = new Mzm\TaxCalculator\App\CountryTax($country);
    echo "========\n";
    echo "Country: {$country->getName()}\n";
    echo "========\n";
    echo "  > overall tax: {$countryTax->getOverallTax()}\n";
    echo "  > Average tax per state: {$countryTax->getAverageTaxPerState()}\n";
    echo "  > Average Tax Rate: {$countryTax->getAverageTaxRate()}\n";
    foreach ($country->getStates() as $state) {
        $stateTax = new Mzm\TaxCalculator\App\StateTax($state);
        echo "  State: {$state->getName()}\n";
        echo "    > Overall tax: {$stateTax->getOverallTax()}\n";
        echo "    > Average tax rate: {$stateTax->getAverageCountyTaxRate()}\n";
        foreach ($state->getCounties() as $county) {
            $countyTax = new Mzm\TaxCalculator\App\CountyTax($county);
            echo "    County: {$county->getName()}\n";
            echo "      > Tax: {$countyTax->getTax()}\n";
        }
    }
}
