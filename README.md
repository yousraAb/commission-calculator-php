# Commission Calculator Test

This is a PHP-based command-line application that calculates commission fees based on BIN data and exchange rates.

## 💡 Problem Statement

You are given a list of transactions in a text file, where each line contains a JSON string with:
- `bin`: card issuer BIN
- `amount`: transaction amount
- `currency`: transaction currency

The goal is to calculate the commission for each transaction by:
1. Looking up the BIN to determine if the country is part of the EU.
2. Using exchange rate API to convert to EUR if needed.
3. Applying a 1% fee for EU transactions, and 2% otherwise.

## ✅ Improvements Made

- Added error handling for missing or invalid data.
- Used dependency injection for flexibility and testability.
- Added support for HTTP APIs using `file_get_contents`.
- Modular structure using PSR-4 autoloading with Composer.

## 🧪 Example

Given `input.txt` with:
```json
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
