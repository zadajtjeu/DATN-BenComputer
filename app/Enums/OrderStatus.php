<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const NEW_ORDER = 1;
    const IN_PROCCESS = 2;
    const IN_SHIPPING = 3;
    const COMPLETED = 4;
    const CANCELED = 0;
}
