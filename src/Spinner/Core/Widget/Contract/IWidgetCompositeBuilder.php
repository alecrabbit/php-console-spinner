<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetCompositeBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IWidgetComposite;

    public function withWidgetRevolver(IRevolver $revolver): IWidgetCompositeBuilder;

    public function withLeadingSpacer(?IFrame $frame): IWidgetCompositeBuilder;

    public function withTrailingSpacer(?IFrame $frame): IWidgetCompositeBuilder;
}
