<?php

if (!function_exists('currency_format')) {
    function currency_format($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . " {$suffix}";
        }

        return __('Contact');
    }
}
