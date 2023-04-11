<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IWidgetComposite;

    public function withWidgetRevolver(IRevolver $revolver): IWidgetBuilder;

    public function withLeadingSpacer(?IFrame $frame): IWidgetBuilder;

    public function withTrailingSpacer(?IFrame $frame): IWidgetBuilder;
}
