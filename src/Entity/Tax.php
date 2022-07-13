<?php

namespace App\Entity;


class Tax
{
    const DEFAULT_PERCENT = 0.2;

    /**
     * @var float
     */
    private float $percent;

    /**
     * @param float $percent
     */
    public function __construct(float $percent = self::DEFAULT_PERCENT)
    {
        $this->percent = $percent;
    }

    /**
     * @param float $amount
     * @return float
     */
    public function applyOnAmount(float $amount): float
    {
        return round($amount * $this->percent, 2);
    }
}