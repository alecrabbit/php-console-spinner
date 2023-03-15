<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Config\A\AConfigBuilder;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IConfigBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig;

    public function withStylePattern(IPattern $pattern): static;

    public function withCharPattern(IPattern $pattern): static;

    public function withRootWidget(IWidgetComposite $widget): static;
}
