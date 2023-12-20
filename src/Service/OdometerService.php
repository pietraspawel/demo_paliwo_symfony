<?php

namespace App\Service;

class OdometerService
{
    /**
     * Calculate traveled and consumption for Odometers.
     */
    public function preprocessCollection(array $collection): void
    {
        foreach ($collection as $key => $odometer) {
            if (!isset($collection[$key + 1])) {
                $traveled = 0;
                $consumption = null;
            } else {
                $nextOdometer = $collection[$key + 1];
                $traveled = $odometer->getValue() - $nextOdometer->getValue();
                $consumption = $odometer->getFuel() / $traveled * 100;
            }
            $odometer
                ->setTraveled($traveled)
                ->setConsumption($consumption);
        }
    }

    /**
     * Have to preprocess collection first.
     */
    public function calculateAverageConsumption(array $collection): float
    {
        $total = 0;
        $elements = 0;
        foreach ($collection as $odometer) {
            if ($odometer->getConsumption()) {
                $total += $odometer->getConsumption();
                $elements++;
            }
        }
        $average = 0;
        if ($elements > 0) {
            $average = $total / $elements;
        }
        return $average;
    }
}
