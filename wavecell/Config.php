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
     *
     * @var string
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
     * This parameter is not mandatory.
     * If used, the brand parameter can be inserted as a placeholder in the text of the message defined in the template object. 
     * The brand could be inserted in plain-text in the text but using placeholders allows you to maintain a single request method while enabling Verify request across a wide range of products or brands.
     * Max Length: 30
     *
     * @var string
     */
    public static $otpBrand;
    
    /**
     * Valid values: "sms" or "call"
     *
     * @var string
     */
    public static $otpChannel;
    
    /**
     * This parameter is not mandatory.
     * The source value can also be called senderID or TPOA.
     * It is the "from" address that will be used when delivering the SMS to the handset.
     * It can take different formats:
     * **Alphanumeric** *(example: MyBrand):* this is the case when a source is composed of an alphanumeric string (max 11 characters: letters from the ASCII character set, digits, and the space character). 
     * Alphanumeric sources are generally used for branded SMS to help the SMS receiver to identify the brand or services which originated the SMS.
     * **Numeric** *(example: +6512345678):* this the case when a source is composed of a string made purely of digits (max 17 chars). It can also start with the + sign. 
     * Numeric sources are generally used when the originator intends to receive an answer to the SMS as it is interpreted as a regular phone number by the destination handset.
     * **NB - Limitations:** According to the country where the SMS is sent to, sources can be overwritten in order to ensure a better delivery.
     * If you have some specific inquiries related to the type of source available for your account towards a specific destination, please contact your account manager.
     * The default value is `OTP`",
     *
     * @var string
     */
    public static $optSmsSource;
    
    /**
     * This parameter is not mandatory.
     * The defaults encoding value is `AUTO`.
     * This parameter defines the character set to use for this SMS among the following:\n\n`AUTO` - `GSM7` - `UCS2`
     * **AUTO**: the API will analyze the content of your SMS text and select the correct encoding according to the characters used: if your SMS text contains UNICODE characters, then UNICODE will be selected, otherwise it will be ASCII
     * **GSM7**: by using GSM7, you are forcing the encoding in use to be GSM 7 bit: it will render correctly any of the characters from the character set (See a complete list <a href=\"https://en.wikipedia.org/wiki/GSM_03.38#GSM_7-bit_default_alphabet_and_extension_table_of_3GPP_TS_23.038_.2F_GSM_03.38\">there</a>).
     * **UCS2**: by using UCS2, you are forcing the encoding in use to be UCS2 encoding: it will render correctly any of the characters from the UNICODE character set (See a complete list <a href=\"https://en.wikipedia.org/wiki/List_of_Unicode_characters8\">there</a>).\n"
     *
     * @var string
     */
    public static $otpSmsEncoding = 'AUTO';
    
    /**
     * Call channel-specific settings in Mobile Verification.
     * This object is not mandatory
     * **This object is taken into account only when the** `channel` **property is set to** `call`"
     * This parameter is not mandatory.
     * It designates your CallerID (caller).
     * Default: "private"
     * @var string
     */
    public static $otpCallSource = 'private';
    
    /**
     * This parameter is not mandatory.
     * It designates the speed of speech in the resulting message.
     * Accepted values range from `0.5` to `2`, as a two digit number.
     * The default value is `0.8`.
     * @var number
     */
    public static $otpCallSpeed = 0.8;
    
    /**
     * This parameter is not mandatory.
     * It designated the amount of times to repeat the text content.
     * Accepted values are `1`, `2` or `3`.
     * The default value is `2`"
     * @var int
     */
    public static $otpCallRepetition = 2;
    
    /**
     * This parameter is not mandatory.
     * It designates the voice, gender and accent for the message you are sending.
     * All available voice profiles can be found at https://developer.wavecell.com/voice/additional-information/languages-voice-profiles.
     * The default value will be chosen based on the **language** parameter value.
     * Max lenght: 50
     */
    public static $otpCallVoiceProfile;

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
