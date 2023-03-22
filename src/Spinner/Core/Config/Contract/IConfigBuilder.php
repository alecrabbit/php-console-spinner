<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IPattern;
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

    public function withStylePattern(IPattern $pattern): static;

    public function withCharPattern(IPattern $pattern): static;

    public function withRootWidget(IWidgetComposite $widget): static;

    public function withWidgets(Traversable $widgets): static;
}
