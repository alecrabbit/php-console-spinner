<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharsRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class VariadicStringRotor extends ACharsRotor
{
    public function __construct(string $string)
    {
        parent::__construct([$string], strlen($string));
    }
}
