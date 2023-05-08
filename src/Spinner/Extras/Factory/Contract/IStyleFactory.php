<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStyleFactory
{
    public function fromString(string $entry): IStyle;
}
