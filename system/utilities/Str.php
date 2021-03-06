<?php

namespace Utilities;

class Str
{

    /**
     * Sanitize an url
     *
     * @param  string url the url
     *
     * @return string the url sanitized
     */
    public static function sanitizeURL(string $url)
    {
        return filter_var(rtrim(strtolower($url), '/'), FILTER_SANITIZE_URL);
    }


    /**
     * Sanitize an email
     *
     * @param  string email the email
     *
     * @return string the email sanitized
     */
    public static function sanitizeEmail(string $email)
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }


    /**
     * Sanitize an string to integer (only numbers and +-)
     *
     * @param  string int the integer
     *
     * @return string the integer sanitized
     */
    public static function sanitizeInt(string $int)
    {
        return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }


    /**
     * Sanitize an string to float (only numbers, fractions and +-)
     *
     * @param  string float the float
     *
     * @return string the float sanitized
     */
    public static function sanitizeFloat(string $float)
    {
        return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }


    /**
     * Sanitize a path for only letters, numbers, underscores, dots and slashes
     *
     * @param  string path the path
     *
     * @return string the path sanitized
     */
    public static function sanitizePath(string $path)
    {
        return preg_replace('/[^a-zA-Z0-9_\-\/. ]/', '', $path);
    }


    /**
     * Returns true if a substring is present in another string
     * or false otherwise
     *
     * @param  string  $str  the string
     * @param  string  $needle  the substring you are looking for
     *
     * @return boolean true if the substring is present in the other string, false otherwise
     */
    public static function contains(string $str, string $needle)
    {
        return strpos($str, $needle) !== false;
    }

    
    /**
     * Returns true if a string starts with another string, false otherwise
     *
     * @param  string  $str  the string
     * @param  string  $needle  the substring
     *
     * @return boolean true if a string starts with another string, false otherwise
     */
    public static function startsWith(string $str, string $needle)
    {
        return substr($str, 0, strlen($needle)) === $needle;
    }


    /**
     * Returns true if a string ends with another string, false otherwise
     *
     * @param  string  $str  the string
     * @param  string  $needle  the substring
     *
     * @return boolean true if a string ends with another string, false otherwise
     */
    public static function endsWith(string $str, string $needle)
    {
        return substr($str, -strlen($needle)) === $needle;
    }


    /**
     * Returns a string with the indicated substring removed
     *
     * @param  string  $str  the string
     * @param  string  $needle  substring to remove
     *
     * @return string the string with the indicated substring removed
     */
    public static function remove(string $str, string $needle)
    {
        return str_replace($needle, '', $str);
    }


    /**
     * Returns everything after the specified substring
     *
     * @param  string  $str  the string
     * @param  string  $needle  substring
     *
     * @return string a string with everything after the specified substring in it
     */
    public static function after(string $str, string $needle)
    {
        return substr($str, strpos($str, $needle) + strlen($needle));
    }


    /**
     * Returns everything before the specified substring
     *
     * @param  string  $str  the string
     * @param  string  $needle  the substring
     *
     * @return string a string with everything before the specified substring in it
     */
    public static function before(string $str, string $needle)
    {
        return substr($str, 0, strpos($str, $needle));
    }

    
    /**
     * Returns a truncated string with the specified length
     *
     * @param  string  $str  the string
     * @param  int  $characters  the number of characters
     *
     * @return string a truncated string with the specified length
     */
    public static function limit(string $str, int $characters)
    {
        return substr($str, 0, $characters);
    }

    
    /**
     * Adds the given value at the start of the string and returns it
     *
     * @param  string  $str  the string
     * @param  string  $start  the string to start with
     *
     * @return string a string starting with the given value
     */
    public static function unshift(string $str, string $start)
    {
        return $start . $str;
    }

    
    /**
     * Returns all the given strings concatenated into one
     *
     * @param  string  $str  the strings
     *
     * @return string all the given strings concatenated into one
     */
    public static function concat(...$strings)
    {
        $aux = '';

        foreach ($strings as $string) {
            $aux .= $string;
        }

        return $aux;
    }

        
    /**
     * Returns the given value to a string
     *
     * @param  mixed  $str  the value
     *
     * @return string the given value as a string
     */
    public static function toString($var)
    {
        //Boolean
        if (is_bool($var)) {
            if ($var === true) {
                return 'true';
            }

            return 'false';
        }

        //Array
        if (is_array($var)) {
            $str = '';

            foreach ($var as $value) {
                $str .= $value;
            }

            return $str;
        }
        
        //Other
        return strval($var);
    }


    /**
     * Returns the directory path with the slashes replaced by backslashes
     *
     * @param  string  $path  the directory path
     *
     * @return string the directory path with the slashes replaced by backslashes
     */
    public static function pathToNamespace(string $path)
    {
        return str_replace('/', '\\', $path);
    }


    /**
     * Returns the directory path with the backslashes replaced by slashes
     *
     * @param  string  $path  the directory path
     *
     * @return string the directory path with the backslashes replaced by slashes
     */
    public static function namespaceToPath(string $path)
    {
        return str_replace('\\', '/', $path);
    }

}