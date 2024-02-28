<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetRevolver;

    public function withChar(IHasCharSequenceFrame $char): IWidgetRevolverBuilder;

    public function withStyle(IHasStyleSequenceFrame $style): IWidgetRevolverBuilder;

    public function withInterval(IInterval $interval): IWidgetRevolverBuilder;
}
