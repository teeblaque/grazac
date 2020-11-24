<?php

function paystack_getcurl($url)
{
    $bearer = 'Authorization: Bearer ' . env('PAYSTACK_SECRET');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Access-Control-Request-Method: GET', 'Access-Control-Allow-Origin: *', 'Content-Type: application/json', $bearer, 'Cache-Control: no-cache'));
    $response = curl_exec($ch);
    curl_close($ch);
    return $resp = json_decode($response, true);
}
