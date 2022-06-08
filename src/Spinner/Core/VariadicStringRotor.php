<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharsRotor;
use AlecRabbit\Spinner\Core\Contract\Base\C;

final class VariadicStringRotor extends ACharsRotor
{
    public function __construct(string $string)
    {
        parent::__construct([$string], WidthQualifier::qualify($string), C::SPACE_CHAR);
    }
}
