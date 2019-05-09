<?php

require_once(__DIR__ . '/../vendor/autoload.php');

require_once(__DIR__ . '/../wavecell/Wavecell.php');

\Wavecell\Config::$timeZone = 'Asia/Jakarta';
\Wavecell\Config::$resendInterval = 120;
\Wavecell\Config::$otpCodeValidity = 600;
\Wavecell\Config::$subAccountId = 'adfadfasdf';
\Wavecell\Config::$secretKey = '2342343243';
\Wavecell\Config::$smsFrom = 'Peruier';

$sms = new \Wavecell\Sms();

/**
 * Without Throw
 */
$response = $sms->sendSingleSms('+6289671000082', 'HALLO WORLD, YOU CAN READ?',
    'AUTO', false);
$body = (string)$response->getBody();
$code = (int)$response->getStatusCode();
if ($code === 400) {
    echo "BAD REQUEST";
} else if ($code === 401) {
    echo "Unauthorized ";
} else if ($code === 404) {
    echo "Not Found";
}

/**
 * With Throws
 */
try {
    $response = $sms->sendSingleSms('+6289671000082', 'HALLO WORLD, YOU CAN READ?',
        'AUTO', true);
    $body = (string)$response->getBody();
    $code = (int)$response->getStatusCode();
} catch (\Wavecell\HttpException $exception) {
    echo $exception->getMessage() . '<br/>';
}
