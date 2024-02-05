<?php
namespace App\Helpers;

use GuzzleHttp\Client;

class CurrencyConverter
{
    public static function convertINRToUSD($amount)
    {
        // Replace 'YOUR_APP_ID' with your Open Exchange Rates App ID
        $openExchangeRatesAppId = '6cc3de4833d241a59d9b57fc670294c7';
        
        $client = new Client();
        
        // Fetch the latest exchange rates
        $response = $client->get("https://open.er-api.com/v6/latest");
        /*dd($response);*/
        $data = json_decode($response->getBody(), true);
        
        // Check if the response was successful
        if ($response->getStatusCode() === 200) {
            // Get the exchange rate for INR to USD
            $inrToUsdRate = $data['rates']['USD'];

            // Perform the conversion
            $usdAmount = $amount / $inrToUsdRate;
            //dd($inrToUsdRate);
            return $usdAmount;
        }

        // Return 0 or handle the error based on your application's requirements
        return 0;
    }
}