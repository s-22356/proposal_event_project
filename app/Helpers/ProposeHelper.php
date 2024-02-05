<?php
//GET APPLICATION NAME

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


//generate random code
if (!function_exists('generateRandomCode')) {
    function generateRandomCode($length = 6)
    {
        $possible_letters = '23456789BCDFGHJKMNPQRSTVWXYZ';
        $code = '';
        for ($x = 0; $x < $length; $x++) {
            $code .= ($num = substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1));
        }
        return $code;
    }
}

if (!function_exists('encryptHEXFormat')) {
    function encryptHEXFormat($data, $key)
    {
        return bin2hex(openssl_encrypt($data, 'aes-256-ecb', $key, OPENSSL_RAW_DATA));
    }
}

if (!function_exists('decryptHEXFormat')) {
    function decryptHEXFormat($data, $key)
    {
        //var_dump( );exit();
        return trim(openssl_decrypt(hex2bin($data), 'aes-256-ecb', $key, OPENSSL_RAW_DATA));
        try {
            if (ctype_xdigit($data)) {
                return 1;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;;
        }
    }
}

if (!function_exists('encryptProposerPhNO')) {
    function encryptProposerPhNO($data)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $CRYPT_NO="1234780005432145";
        $encoded_encryption_iv  =   convert_uuencode($CRYPT_NO);
        $encryption_key = "DAS";
        return openssl_encrypt($data, $ciphering, $encryption_key, $options, convert_uudecode($encoded_encryption_iv));
       
    }
}

if (!function_exists('decryptProposerPhNO')) {
    function decryptProposerPhNO($data)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $CRYPT_NO="1234780005432145";
        $encoded_encryption_iv  =   convert_uuencode($CRYPT_NO);
        $encryption_key = "DAS";
        return openssl_decrypt($data, $ciphering, $encryption_key, $options, convert_uudecode($encoded_encryption_iv));
       
    }
}

if (!function_exists('generateOTP')) {
    function generateOTP()
    {
        $possible_letters = '1234567890';
        $code = '';
        for ($x = 0; $x < 6; $x++) {
            $code .= ($num = substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1));
        }
        return $code;
    }
}

if (!function_exists('decryptProposerPhNO')) {
    function decryptProposerPhNO($data)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234780005432145';
        $encryption_key = "DAS";
        $encryption = openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
        $proposer_no   =    convert_uuencode($encryption);
        return $proposer_no;
       
    }
}

if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}

if (!function_exists('maskInfo')) {
    function maskInfo($data, $type)
    {
        $mask_data = '';
        if (strlen($data) > 0) {
            if ($type == 'phone') {
                $mask_data = substr($data, 0, 2) . 'XXXXXX' . substr($data, -2);
            } else if ($type == 'email') {
                if (strpos($data, '@') !== false) {
                    list($first, $last) = explode('@', $data);
                    if (strlen($first) > 3) {
                        $max = strlen($first) > 7 ? 7 : strlen($first);
                        $first = str_replace(substr($first, '3'), str_repeat('x', $max), $first);
                    } else {
                        $n = strlen($first) - 1;
                        $first = str_replace(substr($first, $n), str_repeat('x', strlen($first) - $n), $first);
                    }

                    $last = explode('.', $last);

                    $last_domain = str_replace(substr($last['0'], '1'), str_repeat('x', strlen($last['0']) - 1), $last['0']);

                    $mask_data = $first . '@' . $last_domain . '.' . $last['1'];
                } else {
                    $mask_data = $data;
                }
            }
        }
        return $mask_data;
    }
}

//GENERATE FLASH MESSAGE
if (!function_exists('flash_message')) {
    function flash_message()
    {
        if (Session::has('message')) {
            Session::flash('message',Session::get('message'));
            list($type, $message) = explode('|', Session::get('message'));
            if ($type == 'error') {
                $type = 'danger';
            } elseif ($type == 'message') {
                $type = 'info';
            } elseif ($type == 'success') {
                $type = 'success';
            }
             if(Session::has('errors')){
                Session::flash('errors',Session::get('errors'));
             }
            return '<div class="alert  flash-message"><i class="fa fa-times flash-msg-close" aria-hidden="true"></i>
            ' . $message . '</div>';
        }

        return '';
    }
}


//currency converter code
if (!function_exists('convertCurrency')) {
    function convertCurrency($from, $to, $amount, $apiKey)
    {
        $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$from";
        //"https://v6.exchangerate-api.com/v6/$apiKey/latest/$from"
        try {
            $response = \Illuminate\Support\Facades\Http::get($url);
            
            if ($response->successful()) {
                
                $exchangeRates = $response->json()['conversion_rates'];
               
                // Assuming that the base currency is USD
                $fromRate = $exchangeRates['USD'];
                $convertedAmount = $amount * $fromRate;
        
                return $convertedAmount;
            } else {
                return ['error' => 'Failed to retrieve exchange rate', 'status' => $response->status()];
            }
        } catch (\Exception $e) {
            return ['error' => 'Exception: ' . $e->getMessage()];
        }
    }
}
   


?>