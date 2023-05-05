<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStyleRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $style): string;
}
