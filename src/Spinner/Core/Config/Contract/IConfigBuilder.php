<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use Traversable;

interface IConfigBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig;

    public function withDriverConfig(IDriverConfig $driverConfig): static;

    public function withLoopConfig(ILoopConfig $loopConfig): static;

    public function withSpinnerConfig(ISpinnerConfig $spinnerConfig): static;

    public function withRootWidgetConfig(IWidgetConfig $widgetConfig): static;
}
