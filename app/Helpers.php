<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;

if (!function_exists('currency_format')) {
    function currency_format($number, $suffix = 'đ')
    {
        return number_format($number, 0, ',', '.') . " {$suffix}";
    }
}

if (!function_exists('rating_star')) {
    function rating_star($avg_rate)
    {
        $star = '';
        foreach (range(1, 5) as $rate) {
            if ($avg_rate >= $rate) {
                $star .= ' <i class="fa fa-star"></i>';
            } elseif ($avg_rate == $rate - 0.5) {
                $star .= ' <i class="fa fa-star-half-o"></i>';
            } else {
                $star .= ' <i class="fa fa-star-o"></i>';
            }
        }

        return $star;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (auth()->check() && auth()->user()->role == UserRole::ADMIN) {
            return true;
        }

        return false;
    }
}

if (!function_exists('isManager')) {
    function isManager()
    {
        if (auth()->check() && auth()->user()->role == UserRole::MANAGER) {
            return true;
        }

        return false;
    }
}
