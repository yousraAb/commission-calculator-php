<?php

namespace App\Provider;

use App\Contract\ExchangeRateProviderInterface;

class ExchangeRateApiProvider implements ExchangeRateProviderInterface
{
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api.exchangerate.host/latest')
    {
        $this->baseUrl = $baseUrl;
    }

    public function getRate(string $currency): float
    {
        if ($currency === 'EUR') {
            return 1.0;
        }

        $response = file_get_contents($this->baseUrl);
        if (!$response) {
            throw new \Exception("Exchange rate lookup failed");
        }

        $data = json_decode($response, true);
        return $data['rates'][$currency] ?? 0.0;
    }
}
