<?php

namespace App\Service;

class OdometerService
{
    /**
     * Calculate traveled and consumption for Odometers.
     */
    public function preprocessArray(array $collection): void
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
}
