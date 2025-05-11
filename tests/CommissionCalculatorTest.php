<?php

use PHPUnit\Framework\TestCase;
use App\Service\CommissionCalculator;
use App\Contract\BinProviderInterface;
use App\Contract\ExchangeRateProviderInterface;

class CommissionCalculatorTest extends TestCase
{
    public function testEUCommission()
    {
        $binProvider = $this->createMock(BinProviderInterface::class);
        $binProvider->method('getCountryCode')->willReturn('FR');

        $rateProvider = $this->createMock(ExchangeRateProviderInterface::class);
        $rateProvider->method('getRate')->willReturn(1.0);

        $calculator = new CommissionCalculator($binProvider, $rateProvider);

        $this->assertEquals(1.00, $calculator->calculate('123456', 100.00, 'EUR'));
    }

    public function testNonEUCommissionWithConversion()
    {
        $binProvider = $this->createMock(BinProviderInterface::class);
        $binProvider->method('getCountryCode')->willReturn('US');

        $rateProvider = $this->createMock(ExchangeRateProviderInterface::class);
        $rateProvider->method('getRate')->willReturn(2.0);

        $calculator = new CommissionCalculator($binProvider, $rateProvider);

        $this->assertEquals(1.00, $calculator->calculate('654321', 100.00, 'USD'));
    }
}
