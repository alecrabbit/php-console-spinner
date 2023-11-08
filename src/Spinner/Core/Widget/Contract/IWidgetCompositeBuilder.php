<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetCompositeBuilder extends IWidgetBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgument
     */
    public function build(): IWidgetComposite;

    public function withWidgetRevolver(IWidgetRevolver $revolver): IWidgetCompositeBuilder;

    public function withLeadingSpacer(IFrame $frame): IWidgetCompositeBuilder;

    public function withTrailingSpacer(IFrame $frame): IWidgetCompositeBuilder;
}
