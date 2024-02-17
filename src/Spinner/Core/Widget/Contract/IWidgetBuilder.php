<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgument
     */
    public function build(): IWidget;

    public function withWidgetRevolver(IWidgetRevolver $revolver): IWidgetBuilder;

    public function withLeadingSpacer(ISequenceFrame $leadingSpacer): IWidgetBuilder;

    public function withTrailingSpacer(ISequenceFrame $trailingSpacer): IWidgetBuilder;
}
