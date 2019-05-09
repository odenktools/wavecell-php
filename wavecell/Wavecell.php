<?php

// Check PHP version.
if (version_compare(PHP_VERSION, '5.2.1', '<')) {
    throw new Exception('PHP version >= 5.2.1 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Wavecell needs the CURL PHP extension.');
}

if (!function_exists('json_decode')) {
    throw new Exception('Wavecell needs the JSON PHP extension.');
}

// Configurations.
require_once dirname(__FILE__) . '/Config.php';

// Helper.
require_once dirname(__FILE__) . '/Helper.php';

// Interface Exception.
require_once dirname(__FILE__) . '/WavecellException.php';

// Exception.
require_once dirname(__FILE__) . '/HttpException.php';

// SMS Interface.
require_once dirname(__FILE__) . '/SmsInterface.php';

// Sms Request.
require_once dirname(__FILE__) . '/Sms.php';
