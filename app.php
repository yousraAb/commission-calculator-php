<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Provider\BinListProvider;
use App\Provider\ExchangeRateApiProvider;
use App\Service\CommissionCalculator;

if (!isset($argv[1])) {
    die("Usage: php app.php input.txt\n");
}

$inputFile = $argv[1];
$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$calculator = new CommissionCalculator(
    new BinListProvider(),
    new ExchangeRateApiProvider()
);

foreach ($lines as $line) {
    $transaction = json_decode($line, true);

    if (!isset($transaction['bin'], $transaction['amount'], $transaction['currency'])) {
        echo "Invalid transaction data\n";
        continue;
    }

    try {
        $commission = $calculator->calculate(
            $transaction['bin'],
            (float)$transaction['amount'],
            $transaction['currency']
        );

        echo number_format($commission, 2, '.', '') . "\n";
    } catch (Exception $e) {
        echo "Error processing transaction: " . $e->getMessage() . "\n";
    }
}
