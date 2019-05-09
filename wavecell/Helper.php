<?php

/**
 * Helper.
 * {{ DESKRIPSI APLIKASI }}.
 *
 * @author     Odenktools
 * @license    MIT
 * @package    Wavecell
 * @copyright  (c) 2019, PerluApps Technology
 */

namespace Wavecell;

class Helper
{
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int $length
     * @return string
     * @throws \Exception;
     */
    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * Generate ISO8601 Time.
     * @param int $minutes . Add Minutes from now
     * @return string
     */
    public static function generateExpired($minutes = 60)
    {
        $date = \Carbon\Carbon::now(\Wavecell\Config::$timeZone);
        date_default_timezone_set(\Wavecell\Config::$timeZone);
        $date->addMinutes($minutes);
        $fmt = $date->format('Y-m-d\TH:i:s.u\Z');
        return $fmt;
    }

    /**
     * Validate Array.
     *
     * @param array $destinationNumber
     * @return bool
     * @throws \Exception
     */
    public static function validateArray($destinationNumber = [])
    {
        if (!is_array($destinationNumber)) {
            return false;
        }
        if (empty($destinationNumber)) {
            return false;
        }

        return true;
    }
}
