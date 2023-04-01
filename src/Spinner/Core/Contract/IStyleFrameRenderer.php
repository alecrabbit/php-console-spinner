<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(int|string|IStyle $entry, OptionStyleMode $styleMode = OptionStyleMode::NONE): IFrame;

    public function isStylingDisabled(): bool;
}
