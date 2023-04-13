<?php

declare(strict_types=1);
// 13.04.23
namespace AlecRabbit\Spinner\Core\Render\Contract;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $style): string;
}
