<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VocherStatus extends Enum
{
    const AVAILABLE =   0;
    const EXPIRED =   1;
    const BLOCK = 2;
}
