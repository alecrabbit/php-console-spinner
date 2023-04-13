<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $entry): IFrame;

    public function isStylingDisabled(): bool;

    public function emptyFrame(): IFrame;
}
