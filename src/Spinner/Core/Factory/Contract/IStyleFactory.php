<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;

interface IStyleFactory
{
    public function fromString(string $entry): IStyle;
}
