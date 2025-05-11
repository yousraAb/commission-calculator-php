<?php

namespace App\Provider;

use App\Contract\BinProviderInterface;

class BinListProvider implements BinProviderInterface
{
    public function getCountryCode(string $bin): string
    {
        $url = 'https://lookup.binlist.net/' . $bin;
        $response = file_get_contents($url);
        if (!$response) {
            throw new \Exception("BIN lookup failed");
        }

        $data = json_decode($response);
        return $data->country->alpha2 ?? 'UNKNOWN';
    }
}
