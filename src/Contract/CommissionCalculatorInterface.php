<?php

namespace App\Contract;

interface CommissionCalculatorInterface
{
    public function calculate(string $bin, float $amount, string $currency): float;
}
