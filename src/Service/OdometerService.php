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
            } else {
                $nextOdometer = $collection[$key + 1];
                $traveled = $odometer->getValue() - $nextOdometer->getValue();
            }
            $odometer->setTraveled($traveled);
        }
    }
}
