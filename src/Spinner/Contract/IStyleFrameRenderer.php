<?php
declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameRenderer extends IFrameRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(string|IStyle $entry, StyleMode $styleMode = StyleMode::NONE): IFrame;
}