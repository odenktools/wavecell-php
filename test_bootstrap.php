<?php

include_once(dirname(__FILE__) . '/vendor/autoload.php');

$dir = dirname(__FILE__);
$config_path = $dir . '/tests/config.php';
if (file_exists($config_path) === true) {
    require_once(dirname(__FILE__) . '/tests/config.php');
} else {
    define('WAVECELL_SUB_ACCOUNT_ID', getenv('WAVECELL_SUB_ACCOUNT_ID'));
    define('WAVECELL_SECRET_KEY', getenv('WAVECELL_SECRET_KEY'));
    define('WAVECELL_SMS_FROM', getenv('WAVECELL_SMS_FROM'));
    define('WAVECELL_COUNTRY', getenv('WAVECELL_COUNTRY'));
    define('WAVECELL_OTP_CODE_LENGTH', getenv('WAVECELL_OTP_CODE_LENGTH'));
    define('WAVECELL_OTP_CODE_VALIDITY', getenv('WAVECELL_OTP_CODE_VALIDITY'));
    define('WAVECELL_RESEND_INTERVAL', getenv('WAVECELL_RESEND_INTERVAL'));
}
require_once(dirname(__FILE__) . '/wavecell/Wavecell.php');
