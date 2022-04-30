<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VoucherCondition extends Enum
{
    const PERCENT =   0;
    const AMOUNT =   1;
}
