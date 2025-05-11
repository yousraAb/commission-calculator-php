<?php

namespace App\Service;

use App\Contract\BinProviderInterface;
use App\Contract\ExchangeRateProviderInterface;
use App\Contract\CommissionCalculatorInterface;

class CommissionCalculator implements CommissionCalculatorInterface
{
    private BinProviderInterface $binProvider;
    private ExchangeRateProviderInterface $rateProvider;

    public function __construct(
        BinProviderInterface $binProvider,
        ExchangeRateProviderInterface $rateProvider
    ) {
        $this->binProvider = $binProvider;
        $this->rateProvider = $rateProvider;
    }

    public function calculate(string $bin, float $amount, string $currency): float
    {
        $countryCode = $this->binProvider->getCountryCode($bin);
        $rate = $this->rateProvider->getRate($currency);

        $eurAmount = $currency === 'EUR' ? $amount : $amount / $rate;
        $isEu = EUChecker::isEu($countryCode);

        $commissionRate = $isEu ? 0.01 : 0.02;
        return ceil($eurAmount * $commissionRate * 100) / 100;
    }
}
