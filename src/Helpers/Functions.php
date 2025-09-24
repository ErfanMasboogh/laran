<?php

if (!function_exists('lt')) {
    /**
     * ###### Laran Translator
     * Returns the translate of given key by checking main project lang's files
     * and then if has no result, it will check Laran package lang's files. if no record matched,
     * will return the key with it's namespace.
     *
     *
     **/
    function lt($key, $variables = [], $namespace = 'app')
    {
        $completeKey = $namespace . '.' . $key;
        $hasVariable = !empty($variables);

        $translatedKey = app('translator')->get($completeKey, $variables);

        return $translatedKey;
    }
}

if (!function_exists('normalizeMobile')) {
    /**
     * Normalize mobile numbers by removing +, 98 and 0.
     *
     * @param $number
     * @return string (The main 10 digits as string)
     */
    function normalizeMobile($number)
    {
        if (!is_string($number)) {
            $number = (string)$number;
        }

        // Remove spaces, dashes, or other non-digit characters
        $number = preg_replace('/\D+/', '', $number);

        $number = ltrim($number, '+');
        if (str_starts_with($number, '98')) {
            $number = substr($number, 2);
        }
        $number = ltrim($number, '0');
        
        return $number;
    }
}
