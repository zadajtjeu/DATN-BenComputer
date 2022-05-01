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

if (!function_exists('rating_star')) {
    function rating_star($avg_rate)
    {
        $star = '';
        foreach (range(1, 5) as $rate) {
            if ($avg_rate >= $rate) {
                $star .= '<i class="fa fa-star"></i>';
            } elseif ($avg_rate == $rate - 0.5) {
                $star .= ' <i class="fa fa-star-half-o"></i>';
            } else {
                $star .= ' <i class="fa fa-star-o"></i>';
            }
        }

        return $star;
    }
}
