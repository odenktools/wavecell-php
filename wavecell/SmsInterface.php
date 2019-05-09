<?php

namespace Wavecell;

/**
 * Sms interface for sending SMS requests.
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2019, Pribumi Technology
 */
interface SmsInterface
{
    const VERSION = '1.0.0';

    /**
     * Send SMS to Client.
     *
     * @see https://developer.wavecell.com/v1/api-documentation/send-sms-single.
     * @since 1.0.0.
     *
     * @param string $destination phone number do want to send.
     * @param string $smsText Content do you want to send.
     * @param string $smsEncoding 'AUTO', 'GSM7', 'UC'.
     * @param bool $throws
     * @return \Psr\Http\Message\ResponseInterface|mixed
     * @throws \Wavecell\HttpException
     */
    public function sendSingleSms($destination, $smsText, $smsEncoding = 'AUTO', $throws = true);

    /**
     * Send SMS to Client(s) by batches (1 request for multiple SMS).
     *
     * @see https://developer.wavecell.com/v1/api-documentation/send-many-sms.
     * @since 1.0.0.
     *
     * @param string $smsText Content do you want to send.
     * @param array $destinationNumber phone number do want to send.
     * @param string $smsEncoding 'AUTO', 'GSM7', 'UC'.
     * @param bool $throws Throw if fails?.
     * @return \Psr\Http\Message\ResponseInterface|mixed
     * @throws \Wavecell\HttpException
     */
    public function sendMultipleSms($smsText, $destinationNumber = [], $smsEncoding = 'AUTO', $throws = true);

    /**
     * Send OTP to Client.
     *
     * @see https://developer.wavecell.com/v1/api-documentation/verify-code-generation.
     * @since 1.0.0.
     *
     * @param string $destination phone number do want to send.
     * @param $throws bool Throw if fails?.
     * @return \Psr\Http\Message\ResponseInterface|mixed
     * @throws \Wavecell\HttpException
     */
    public function sendOtpSms($destination, $throws = true);

    /**
     * Verify OTP code from Client.
     *
     * @see https://developer.wavecell.com/v1/api-documentation/verify-code-validation.
     * @since 1.0.0.
     *
     * @param string $uid Example code is '92916175-4e7c-49ab-a872-31be92dba263'.
     * @param string $code Example code is '608273'.
     * @param bool $throws Throw if fails?.
     * @return \Psr\Http\Message\ResponseInterface|mixed
     * @throws \Wavecell\HttpException
     */
    public function verifyOtpSms($uid, $code, $throws = true);
}
