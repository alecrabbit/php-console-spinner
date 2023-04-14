<?php

declare(strict_types=1);
// 13.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;

interface IStyleFactory
{
    public function fromString(string $entry): IStyle;
}
