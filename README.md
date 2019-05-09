# Wavecell SMS PHP API Library

Wavecell SMS PHP API Library was created by and is maintained by [Odenktools](https://github.com/odenktools).

For details information see [Wavecell Documentation](https://developer.wavecell.com/v1/api-documentation).

## PHP Version Support

- [x] PHP 5.4.x
- [x] PHP 5.5.x
- [x] PHP 5.6.x
- [ ] PHP 7.0.x
- [ ] PHP 7.1.x
- [ ] PHP 7.2.x
- [ ] PHP 7.3.x

# Installation

```bash
composer require odenktools/wavecell-php
```

# Usage

##### Send Single SMS

Send SMS individually (1 request per SMS).

See for detail [Send SMS - Single](https://developer.wavecell.com/v1/api-documentation/send-many-sms)

**Sample (Without Throwing)**

```php
\Wavecell\Config::$timeZone = 'Asia/Jakarta';
\Wavecell\Config::$country = 'ID';
\Wavecell\Config::$resendInterval = 120;
\Wavecell\Config::$otpCodeValidity = 600;
\Wavecell\Config::$otpCodeLength = 6;
\Wavecell\Config::$smsExpireInMinutes = 60;
\Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
\Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
\Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

$sms = new \Wavecell\Sms();
$response = $sms->sendSingleSms('+6289671000082', 'HELLO WORLD, YOU CAN READ THIS SMS?', 'AUTO', false);
$body = (string)$response->getBody();
$code = (int)$response->getStatusCode();
if ($code === 400) {
    echo "BAD REQUEST";
} else if ($code === 401) {
    echo "Unauthorized ";
} else if ($code === 404) {
    echo "Not Found";
} else if ($code === 200) {
    $content = json_decode($body);
    echo $code . '<br/>';
    echo $content->status->code . '<br/>';
    echo $content->status->description. '<br/>';
    echo $content->umid. '<br/>';
    echo $content->encoding. '<br/>';
    echo $content->destination. '<br/>';
}
```

##### Send Single SMS

**Sample (With Throwing)**

```php
try {
    \Wavecell\Config::$timeZone = 'Asia/Jakarta';
    \Wavecell\Config::$country = 'ID';
    \Wavecell\Config::$resendInterval = 120;
    \Wavecell\Config::$otpCodeValidity = 600;
    \Wavecell\Config::$otpCodeLength = 6;
    \Wavecell\Config::$smsExpireInMinutes = 60;
    \Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
    \Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
    \Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

    $sms = new \Wavecell\Sms();
    $response = $sms->sendSingleSms('+6289671000082', 'HELLO WORLD, YOU CAN READ THIS SMS?', 'AUTO', true);
    $body = (string)$response->getBody();
    $code = (int)$response->getStatusCode();
    echo $code . '<br/>';
    echo $content->status->code . '<br/>';
    echo $content->status->description. '<br/>';
    echo $content->umid. '<br/>';
    echo $content->encoding. '<br/>';
    echo $content->destination. '<br/>';
} catch (\Wavecell\HttpException $exception) {
    echo $exception->getMessage();
}
```

##### Send Batch SMS

Send SMS by batches (1 request for multiple SMS) with personalized contents/properties.

Using this API, it is possible to send up to **10,000 SMS per request**.

See for detail [Send SMS - Many](https://developer.wavecell.com/v1/api-documentation/send-many-sms)

**Sample (With Throwing)**

```php
try {
    \Wavecell\Config::$timeZone = 'Asia/Jakarta';
    \Wavecell\Config::$country = 'ID';
    \Wavecell\Config::$resendInterval = 120;
    \Wavecell\Config::$otpCodeValidity = 600;
    \Wavecell\Config::$otpCodeLength = 6;
    \Wavecell\Config::$smsExpireInMinutes = 60;
    \Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
    \Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
    \Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

    $sms = new \Wavecell\Sms();
    $numbers = array('+6289680000000', '+6289680000001');
    $response = $sms->sendMultipleSms('HELLO WORLD, YOU CAN READ THIS SMS?', $numbers);
    $body = (string)$response->getBody();
    $code = (int)$response->getStatusCode();
    echo $code . '<br/>';
    echo $content->status->code . '<br/>';
    echo $content->status->description. '<br/>';
    echo $content->umid. '<br/>';
    echo $content->encoding. '<br/>';
    echo $content->destination. '<br/>';
} catch (\Wavecell\HttpException $exception) {
    echo $exception->getMessage();
}
```

**Sample (Without Throwing)**

```php
\Wavecell\Config::$timeZone = 'Asia/Jakarta';
\Wavecell\Config::$country = 'ID';
\Wavecell\Config::$resendInterval = 120;
\Wavecell\Config::$otpCodeValidity = 600;
\Wavecell\Config::$otpCodeLength = 6;
\Wavecell\Config::$smsExpireInMinutes = 60;
\Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
\Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
\Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

$sms = new \Wavecell\Sms();
$numbers = array('+6289680000000', '+6289680000001');
$response = $sms->sendMultipleSms('HELLO WORLD, YOU CAN READ THIS SMS?', $numbers, 'AUTO', false);
$body = (string)$response->getBody();
$code = (int)$response->getStatusCode();
if ($code === 400) {
    echo "BAD REQUEST";
} else if ($code === 401) {
    echo "Unauthorized ";
} else if ($code === 404) {
    echo "Not Found";
} else if ($code === 200) {
    $content = json_decode($body);
    echo $content->status->code . '<br/>';
    echo $content->status->description. '<br/>';
    echo $content->umid. '<br/>';
    echo $content->encoding. '<br/>';
    echo $content->destination. '<br/>';
}
```

##### Send OTP SMS

See for detail [Mobile Verification - Code generation](https://developer.wavecell.com/v1/api-documentation/verify-code-generation)

**Sample (With Throwing)**

```php
try {
    \Wavecell\Config::$timeZone = 'Asia/Jakarta';
    \Wavecell\Config::$country = 'ID';
    \Wavecell\Config::$resendInterval = 120;
    \Wavecell\Config::$otpCodeValidity = 600;
    \Wavecell\Config::$otpCodeLength = 6;
    \Wavecell\Config::$smsExpireInMinutes = 60;
    \Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
    \Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
    \Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

    $sms = new \Wavecell\Sms();
    $response = $sms->sendOtpSms('+6289680000000', true);
    $body = (string)$response->getBody();
    $code = (int)$response->getStatusCode();
    echo $content->resourceUri . '<br/>';
    echo $content->uid . '<br/>';
    echo $content->status . '<br/>';
    echo $content->attempt. '<br/>';
    echo $content->expiresAt. '<br/>';
    echo $content->nextSmsAfter. '<br/>';
} catch (\Wavecell\HttpException $exception) {
    echo $exception->getMessage();
}
```

**Sample (Without Throwing)**

```php
\Wavecell\Config::$timeZone = 'Asia/Jakarta';
\Wavecell\Config::$country = 'ID';
\Wavecell\Config::$resendInterval = 120;
\Wavecell\Config::$otpCodeValidity = 600;
\Wavecell\Config::$otpCodeLength = 6;
\Wavecell\Config::$smsExpireInMinutes = 60;
\Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
\Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
\Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

$sms = new \Wavecell\Sms();
$numbers = array('+6289680000000', '+6289680000001');
$response = $sms->sendOtpSms('+6289680000000', false);
$body = (string)$response->getBody();
$code = (int)$response->getStatusCode();
if ($code === 400) {
    echo "BAD REQUEST";
} else if ($code === 401) {
    echo "Unauthorized ";
} else if ($code === 404) {
    echo "Not Found";
} else if ($code === 200) {
    $content = json_decode($body);
    echo $content->resourceUri . '<br/>';
    echo $content->uid . '<br/>';
    echo $content->status . '<br/>';
    echo $content->attempt. '<br/>';
    echo $content->expiresAt. '<br/>';
    echo $content->nextSmsAfter. '<br/>';
}
```

##### Verification OTP

See for detail [Mobile Verification - Code validation](https://developer.wavecell.com/v1/api-documentation/verify-code-validation)

**Sample (With Throwing)**

```php
try {
    \Wavecell\Config::$timeZone = 'Asia/Jakarta';
    \Wavecell\Config::$country = 'ID';
    \Wavecell\Config::$resendInterval = 120;
    \Wavecell\Config::$otpCodeValidity = 600;
    \Wavecell\Config::$otpCodeLength = 6;
    \Wavecell\Config::$smsExpireInMinutes = 60;
    \Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
    \Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
    \Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

    $sms = new \Wavecell\Sms();
    $response = $sms->verifyOtpSms('683cc08a-bf70-e911-8145-02d9baaa9e6f', '908273');
    $body = (string)$response->getBody();
    $code = (int)$response->getStatusCode();
    echo $content->resourceUri . '<br/>';
    echo $content->uid . '<br/>';
    echo $content->msisdn . '<br/>';
    echo $content->status . '<br/>';
    echo $content->attempt. '<br/>';
    echo $content->expiresAt. '<br/>';
} catch (\Wavecell\HttpException $exception) {
    echo $exception->getMessage();
}
```

**Sample (Without Throwing)**

```php
\Wavecell\Config::$timeZone = 'Asia/Jakarta';
\Wavecell\Config::$country = 'ID';
\Wavecell\Config::$resendInterval = 120;
\Wavecell\Config::$otpCodeValidity = 600;
\Wavecell\Config::$otpCodeLength = 6;
\Wavecell\Config::$smsExpireInMinutes = 60;
\Wavecell\Config::$subAccountId = 'YOUR_SUB_ACCOUNT_ID';
\Wavecell\Config::$secretKey = 'YOUR_SECRET_KEY';
\Wavecell\Config::$smsFrom = 'YOUR_APP_SETTING';

$sms = new \Wavecell\Sms();
$response = $sms->verifyOtpSms('683cc08a-bf70-e911-8145-02d9baaa9e6f', '908273', false);
$body = (string)$response->getBody();
$code = (int)$response->getStatusCode();
if ($code === 400) {
    echo "BAD REQUEST";
} else if ($code === 401) {
    echo "Unauthorized ";
} else if ($code === 404) {
    echo "Not Found";
} else if ($code === 200) {
    $content = json_decode($body);
    echo $content->resourceUri . '<br/>';
    echo $content->uid . '<br/>';
    echo $content->msisdn . '<br/>';
    echo $content->status . '<br/>';
    echo $content->attempt. '<br/>';
    echo $content->expiresAt. '<br/>';
}
```

# Test

**Using Composer**

```bash
composer run-script test:ci
```

**Using PHPUnit**

```bash
vendor/bin/phpunit --verbose --coverage-text
```

# LICENSE

MIT License

Copyright (c) 2019 odenktools

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
