<?php

namespace Wavecell;

/**
 * WaveCell Configuration.
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2019, Pribumi Technology
 */
class Config
{
    const BASE_URL = 'https://api.wavecell.com';

    /**
     * Sub Account Id.
     *
     * @var string
     */
    public static $subAccountId;

    /**
     * Secret API.
     *
     * @var string
     */
    public static $secretKey;

    /**
     * be used to personalized the content of your message template with your product name or brand name.
     * @var $smsFrom string
     */
    public static $smsFrom;

    /**
     * Maximum expired time from now + $smsExpireInMinutes.
     *
     * @var int
     */
    public static $smsExpireInMinutes = 60;

    /**
     * Default timezone.
     *
     * @var string
     */
    public static $timeZone = 'Asia/Jakarta';

    /**
     * Value used to set the length of the code to be generated.
     *
     * @var int
     */
    public static $otpCodeLength = 6;

    /**
     * Value used to set how long the code generated should remain valid for verification. The value is expressed in seconds.
     *
     * @var int
     */
    public static $otpCodeValidity = 600;

    /**
     * Value used to define the minimum interval in second allowed before a new verification request
     * can be sent to the same destination phone number.
     *
     * @var int
     */
    public static $resendInterval = 120;

    /**
     * 2-chars ISO country code (ex: SG, UK, ID).
     *
     * @var string
     */
    public static $country;

    /**
     * Curl Options.
     *
     * @var array
     */
    public static $curlOptions = array();

    /**
     * Get default URL.
     *
     * @return string
     */
    public static function getBaseUrl()
    {
        return Config::BASE_URL;
    }
}
