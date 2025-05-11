<?php

namespace App\Contract;

interface ExchangeRateProviderInterface
{
    public function getRate(string $currency): float;
}
