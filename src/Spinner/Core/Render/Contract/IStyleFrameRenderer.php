<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Render\Contract;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $style): IFrame;
}
