<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Rotor\Contract\AStringRotor;
use AlecRabbit\Spinner\Core\WidthQualifier;

final class VariadicStringRotor extends AStringRotor
{
    public function __construct(string $string)
    {
        parent::__construct([$string], WidthQualifier::qualify($string), C::SPACE_CHAR);
    }
}
