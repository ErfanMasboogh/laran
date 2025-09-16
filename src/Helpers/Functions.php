<?php

if (!function_exists('lt')){
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
