<?php

echo "<pre>";
print_r($_SERVER['REMOTE_ADDR']);


$ip= $_SERVER['REMOTE_ADDR'];
$ip_val = curl_init('https://ipwhois.app/json/'. $ip);

curl_setopt($ip_val, CURLOPT_RETURNTRANSFER, true);
$json_value = curl_exec($ip_val);

curl_close($ip_val);
$ip_result = json_decode($json_value, true);

$user_ip = $ip_result['ip'];
$user_continent = $ip_result['continent'];
$user_continentCode = $ip_result['continent_code'];
$user_country = $ip_result['country'];
$user_countryCode = $ip_result['country_code'];
$user_countryFlag = $ip_result['country_flag'];
$user_countryPhone = $ip_result['country_phone'];
$user_city = $ip_result['city'];
$user_region = $ip_result['region'];
$user_latitude = $ip_result['latitude'];
$user_longitude = $ip_result['longitude'];
$user_timezone = $ip_result['timezone'];
$user_timezoneName = $ip_result['timezone_name'];
$user_timezoneDstOffSet = $ip_result['timezone_dstOffset'];
$user_timezoneGmtOffSet = $ip_result['timezone_gmtOffset'];
$user_timezoneGmt = $ip_result['timezone_gmt'];
$user_currency = $ip_result['currency'];
$user_currencyCode = $ip_result['currency_code'];
$user_currencySymbol = $ip_result['currency_symbol'];
$user_currencyRates = $ip_result['currency_rates'];
$user_currencyPlural = $ip_result['currency_plural'];
