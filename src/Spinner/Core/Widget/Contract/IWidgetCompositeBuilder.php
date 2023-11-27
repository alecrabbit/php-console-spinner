<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
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

    public function withLeadingSpacer(IFrame $leadingSpacer): IWidgetCompositeBuilder;

    public function withTrailingSpacer(IFrame $trailingSpacer): IWidgetCompositeBuilder;

    public function withIntervalComparator(IIntervalComparator $intervalComparator): IWidgetCompositeBuilder;
}
