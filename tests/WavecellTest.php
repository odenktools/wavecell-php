<?php

if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
}

class WavecellTest extends PHPUnit_Framework_TestCase
{
    public static function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Get base URL.
     */
    public function testReturnBaseUrl()
    {
        $this->assertEquals(
            \Wavecell\Config::getBaseUrl(),
            'https://api.wavecell.com'
        );
    }

    /**
     * Test get subaccountid.
     *
     */
    public function testSubAccountId()
    {
        $this->assertEquals(WAVECELL_SUB_ACCOUNT_ID, 'VALUE_SUB_ACCOUNT_ID');
    }

    /**
     * Test get SecretKey.
     */
    public function testSecretKey()
    {
        $this->assertEquals(WAVECELL_SECRET_KEY, 'VALUE_SECRET_KEY');
    }

    /**
     * Test generate Expired Time.
     */
    public function testGenerateExpired()
    {
        $this->assertNotEquals(\Wavecell\Helper::generateExpired(), '2019-05-08T12:38:41.251939Z');
    }

    public function testValidateArr()
    {
        $wave = $this->getMockForAbstractClass('\Wavecell\Helper');
        $arr = array();
        $settings = self::invokeMethod($wave, 'validateArray', array($arr));
        $this->assertFalse($settings);
    }

    public function testValidateArr2()
    {
        $wave = $this->getMockForAbstractClass('\Wavecell\Helper');
        $settings = self::invokeMethod(
            $wave,
            'validateArray',
            array('+6289680000000', '+6289680000001')
        );
        $this->assertFalse($settings);
    }

    /**
     * Test fail send single sms.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testSingleSmsThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendSingleSms('+6289680000000', 'Hallo World', 'AUTO', true);
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send single sms.
     */
    public function testSingleSms()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendSingleSms('+6289680000000', 'Hallo World', '', false);
        $body = (string)$response->getBody();
        $code = (int)$response->getStatusCode();
        $content = json_decode($body);

        $this->assertEquals($content->message, 'Request was not authenticated properly');
        $this->assertEquals($code, 401);
        $this->assertEquals($content->code, 1200);
    }

    /**
     * Test fail send single sms with throwing error.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testSingleSmsEncodingThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendSingleSms('+6289680000000', 'Hallo World', 'AUTO');
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send single sms without throwing error.
     */
    public function testSingleSmsEncoding()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendSingleSms('+6289680000000', 'Hallo World', 'AUTO', false);
        $body = (string)$response->getBody();
        $code = (int)$response->getStatusCode();
        $content = json_decode($body);
        $this->assertEquals($content->message, 'Request was not authenticated properly');
        $this->assertEquals($code, 401);
        $this->assertEquals($content->code, 1200);
    }

    /**
     * Test fail send single sms.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testSingleSmsExpired()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;
        \Wavecell\Config::$smsExpireInMinutes = WAVECELL_SMS_EXPIRED_IN_MINUTES;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendSingleSms('+6289680000000', 'Hallo World', 'AUTO');
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send single sms.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testMultipleSmsThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;
        \Wavecell\Config::$smsExpireInMinutes = WAVECELL_SMS_EXPIRED_IN_MINUTES;

        $sms = new \Wavecell\Sms();
        $numbers = array('+6289680000000', '+6289680000001');
        $response = $sms->sendMultipleSms('Hallo World', $numbers);
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send multiple sms without throwing error.
     */
    public function testMultipleSms()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;
        \Wavecell\Config::$smsExpireInMinutes = WAVECELL_SMS_EXPIRED_IN_MINUTES;

        $sms = new \Wavecell\Sms();
        $numbers = array('+6289680000000', '+6289680000001');
        $response = $sms->sendMultipleSms('Hallo World', $numbers, 'AUTO', false);
        $body = (string)$response->getBody();
        $code = (int)$response->getStatusCode();
        $content = json_decode($body);
        $this->assertEquals($content->message, 'Request was not authenticated properly');
        $this->assertEquals($code, 401);
        $this->assertEquals($content->code, 1200);
    }

    /**
     * Test fail send multiple sms.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testMultipleSmsEncodingThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;
        \Wavecell\Config::$smsExpireInMinutes = WAVECELL_SMS_EXPIRED_IN_MINUTES;

        $sms = new \Wavecell\Sms();
        $numbers = array('+6289680000000', '+6289680000001');
        $response = $sms->sendMultipleSms('Hallo World', $numbers, '');
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send multiple sms with throwing error.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testMultipleSmsNoNumberThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;
        \Wavecell\Config::$smsExpireInMinutes = WAVECELL_SMS_EXPIRED_IN_MINUTES;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendMultipleSms('Hallo World', '+6289680000001', '');
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send OTP sms with throwing error.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testSendOtpSmsThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendOtpSms('+6289680000000');
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail send OTP sms without throwing error.
     */
    public function testSendOtpSms()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->sendOtpSms('+6289680000000', false);
        $body = (string)$response->getBody();
        $code = (int)$response->getStatusCode();
        $content = json_decode($body);
        $this->assertEquals($content->message, 'Request was not authenticated properly');
        $this->assertEquals($code, 401);
        $this->assertEquals($content->code, 1200);
    }

    /**
     * Test fail verification OTP with throwing error.
     *
     * @expectedException \Wavecell\HttpException
     */
    public function testVerifyOtpSmsThrow()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->verifyOtpSms('683cc08a-bf70-e911-8145-02d9baaa9e6f', '908273');
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test fail verification OTP.
     */
    public function testVerifyOtpSms()
    {
        \Wavecell\Config::$resendInterval = 120;
        \Wavecell\Config::$subAccountId = WAVECELL_SUB_ACCOUNT_ID;
        \Wavecell\Config::$secretKey = WAVECELL_SECRET_KEY;
        \Wavecell\Config::$smsFrom = WAVECELL_SMS_FROM;

        $sms = new \Wavecell\Sms();
        $response = $sms->verifyOtpSms('683cc08a-bf70-e911-8145-02d9baaa9e6f', '908273', false);
        $body = (string)$response->getBody();
        $code = (int)$response->getStatusCode();
        $content = json_decode($body);
        $this->assertEquals($content->message, 'Request was not authenticated properly');
        $this->assertEquals($code, 401);
        $this->assertEquals($content->code, 1200);
    }

    public function tearDown()
    {
        \Wavecell\Config::$resendInterval = 120;
    }
}
