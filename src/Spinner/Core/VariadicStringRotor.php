<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharsRotor;

final class VariadicStringRotor extends ACharsRotor
{
    public function __construct(string $string)
    {
        parent::__construct([$string], strlen($string));
    }
}
