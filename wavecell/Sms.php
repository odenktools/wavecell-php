<?php

namespace Wavecell;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Wavecell\Config;
use Wavecell\Helper;
use Wavecell\HttpException;
use Wavecell\SmsInterface;
use Exception;

/**
 * Wavecell SMS REST API Library.
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2019, Pribumi Technology
 */
class Sms implements SmsInterface
{
    /**
     * @var object
     */
    private $response;

    /**
     * The Array of Curl Options.
     *
     * @var array
     */
    private $curlOpts;

    /**
     * \Wavecell\Sms constructor.
     */
    public function __construct()
    {
        $this->curlOpts = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => '0',
            CURLOPT_SSL_VERIFYPEER => '0',
            CURLOPT_AUTOREFERER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_FOLLOWLOCATION => '1',
            CURLOPT_VERBOSE => true
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function sendSingleSms($destination, $smsText, $smsEncoding = 'AUTO', $throws = true)
    {
        try {
            if ($smsEncoding === '') {
                $smsEncoding = 'AUTO';
            }
            $url = Config::getBaseUrl() . '/sms/v1/' . Config::$subAccountId . '/single';
            $guzzleClient = new Client();
            $body = array();
            $body['clientMessageId'] = Helper::random(50);
            $body['source'] = Config::$smsFrom;
            $body['destination'] = $destination;
            $body['text'] = $smsText;
            $body['encoding'] = $smsEncoding;
            $body['expiry'] = Helper::generateExpired(Config::$smsExpireInMinutes);
            uksort($body, 'strcmp');
            $curls = array_merge(Config::$curlOptions, $this->curlOpts);
            $this->response = $guzzleClient->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::$secretKey,
                    'Content-Type' => 'application/json',
                    'curl' => $curls
                ],
                'json' => $body
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
            if ($throws) {
                $body = (string)$this->response->getBody();
                $code = (int)$this->response->getStatusCode();
                $content = json_decode($body);
                throw new HttpException(isset($content->message) ? $content->message : 'Request not processed.', $code);
            } else {
                return $this->response;
            }
        }
        return (string)$this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function sendMultipleSms($smsText, array $destinationNumber = [], $smsEncoding = 'AUTO', $throws = true)
    {
        try {
            if ($smsEncoding === '') {
                $smsEncoding = 'AUTO';
            }
            if (empty($destinationNumber)) {
                throw new HttpException('Destination must not empty.');
            }
            $url = Config::getBaseUrl() . '/sms/v1/' . Config::$subAccountId . '/single';
            $guzzleClient = new Client();
            $body = array('clientBatchId' => Helper::random(50),
                'messages' => array(),
                'template' => array('source' => Config::$smsFrom,
                    'text' => $smsText, 'encoding' => $smsEncoding,
                    'expiry' => Helper::generateExpired(2880)
                ),
                'includeMessagesInResponse' => true
            );
            foreach ($destinationNumber as $key => $value) {
                $clientData = array();
                $clientData['clientMessageId'] = Helper::random(50);
                $clientData['source'] = \Wavecell\Config::$smsFrom;
                $clientData['destination'] = $value;
                $clientData['text'] = $smsText;
                $clientData['encoding'] = $smsEncoding;
                $clientData['expiry'] = Helper::generateExpired(Config::$smsExpireInMinutes);
                uksort($clientData, 'strcmp');
                array_push($body['messages'], $clientData);
            }
            uksort($body, 'strcmp');
            $curls = array_merge(Config::$curlOptions, $this->curlOpts);
            $this->response = $guzzleClient->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::$secretKey,
                    'Content-Type' => 'application/json',
                    'curl' => $curls
                ],
                'json' => $body
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
            if ($throws) {
                $body = (string)$this->response->getBody();
                $code = (int)$this->response->getStatusCode();
                $content = json_decode($body);
                throw new HttpException(isset($content->message) ? $content->message : 'Request not processed.', $code);
            } else {
                return $this->response;
            }
        }
        return (string)$this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function sendOtpSms($destination, $throws = true)
    {
        try {
            $url = Config::getBaseUrl() . '/verify/v2/' . Config::$subAccountId;
            $guzzleClient = new Client();
            $body = array();
            $body['country'] = Config::$country;
            $body['destination'] = $destination;
            $body['brand'] = Config::$otpBrand;
            $body['codeLength'] = Config::$otpCodeLength;
            $body['codeValidity'] = Config::$otpCodeValidity;
            $body['resendingInterval'] = Config::$resendInterval;
            switch(Config::$otpChannel) {
                case "sms":
                    if (isset(Config::$optSmsSource)) {
                        $body['sms']['source'] = Config::$optSmsSource; 
                    } else { 
                        $body['sms']['source'] = Config::$smsFrom; 
                    }
                    $body['sms']['encoding'] = Config::$otpSmsEncoding;
                    break;
                case "call":
                    $body['call']['source'] = Config::$optCallSource;
                    $body['call']['speed'] = Config::$optCallSpeed;
                    $body['call']['repetition'] = Config::$otpCallRepetition;
                	if (isset(Config::$otpCallVoiceProfile)) { 
                	    $body['call']['voiceProfile'] = Config::$otpCallVoiceProfile;
                	}
                	break;
                default:
                    throw new Exception(PHP_EOL. "***You must specify an OTP channel type***" . PHP_EOL);
                    break;
            }
            $body['channel'] = Config::$otpChannel;
            uksort($body, 'strcmp');
            $curls = array_merge(Config::$curlOptions, $this->curlOpts);
            $this->response = $guzzleClient->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::$secretKey,
                    'Content-Type' => 'application/json',
                    'curl' => $curls
                ],
                'json' => $body
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
            if ($throws) {
                $body = (string)$this->response->getBody();
                $code = (int)$this->response->getStatusCode();
                $content = json_decode($body);
                throw new HttpException(isset($content->message) ? $content->message : 'Request not processed.', $code);
            } else {
                return $this->response;
            }
        } catch (Exception $exception) {
            print $exception;
            return PHP_EOL;
        }
        return (string)$this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function verifyOtpSms($uid, $code, $throws = true)
    {
        try {
            $url = Config::getBaseUrl() . "/verify/v1/" . Config::$subAccountId . "/$uid?code=$code";
            $guzzleClient = new Client();
            $curls = array_merge(Config::$curlOptions, $this->curlOpts);
            $this->response = $guzzleClient->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::$secretKey,
                    'Content-Type' => 'application/json',
                    'curl' => $curls
                ]
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
            if ($throws) {
                $body = (string)$this->response->getBody();
                $code = (int)$this->response->getStatusCode();
                $content = json_decode($body);
                throw new HttpException(isset($content->message) ? $content->message : 'Request not processed.', $code);
            } else {
                return $this->response;
            }
        }
        $data = json_decode($this->response->getBody());
        if (strtoupper($data->status) !== 'VERIFIED') {
            throw new HttpException('Error verifiying code.', 400);
        }
        return (string)$this->response->getBody();
    }
}
