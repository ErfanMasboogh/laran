<?php

namespace ErfanMasboogh\Laran\Enums\Traits;

trait HasEnumOptions
{
    /**
     * Return an array of all values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * Return the translated format of received value
     *
     * @param $value
     * @return string
     */
    public static function translate($value): string
    {
        return lt($value);
    }

    /**
     * Return an array of all values in translated format
     *
     * @return array
     */
    public static function translatedValues(): array
    {
        $translatedValues = [];

        foreach (static::values() as $value) {
            $translatedValues[$value] = static::translate($value);
        }

        return $translatedValues;
    }
}
