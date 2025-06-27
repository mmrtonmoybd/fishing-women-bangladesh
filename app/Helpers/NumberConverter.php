<?php

if (! function_exists('convertBengaliToEnglish')) {
    /**
     * Convert Bengali numbers to English numbers
     *
     * @param  string  $bengaliNumber
     * @return string
     */
    function convertBengaliToEnglish($bengaliNumber = '')
    {
        if (! empty($bengaliNumber)) {

            // Mapping of Bengali to English digits
            $bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            // Remove all non-digit characters except the decimal point
            $cleanedNumber = preg_replace('/[^\d.]/u', '', $bengaliNumber);

            // Replace Bengali digits with English digits
            return str_replace($bengaliDigits, $englishDigits, $cleanedNumber);
        } else {
            return null;
        }
    }
}

if (! function_exists('getSettingValue')) {
    function getSettingValue($key)
    {
        $setting = Illuminate\Support\Facades\DB::table('settings')
            ->select('key', 'value')
            ->where('key', $key)
            ->first();

        return $setting ? trim($setting->value, '"\'') : null;
    }
}
