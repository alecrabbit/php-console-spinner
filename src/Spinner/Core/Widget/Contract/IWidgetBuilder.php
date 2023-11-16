<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
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

    public function withLeadingSpacer(IFrame $frame): IWidgetBuilder;

    public function withTrailingSpacer(IFrame $frame): IWidgetBuilder;
}
