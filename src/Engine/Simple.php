<?php

namespace App\Engine;

class Simple
{
    const PRECISION = 6;

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public static function multiply(float $a, float $b): float
    {
        return round($a * $b, static::PRECISION);
    }

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    protected static function sum(float $a, float $b): float
    {
        return round($a + $b, static::PRECISION);
    }

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    private static function modulo(float $a, float $b): float
    {
        return round($a % $b, static::PRECISION);
    }

}