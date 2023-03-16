<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;

abstract class AWidgetRevolverBuilder implements IWidgetRevolverBuilder
{
    protected ?IRevolver $styleRevolver;
    protected ?IRevolver $charRevolver;

    public function __construct(
        protected IDefaults $defaults,
    ) {
    }

    /** @inheritdoc */
    public function build(): IRevolver
    {
        $this->processDefaults();

        return
            new WidgetRevolver(
                $this->styleRevolver,
                $this->charRevolver,
            );
    }

    protected function processDefaults(): void
    {
        $this->styleRevolver ??= $this->defaultStyleRevolver();
        $this->charRevolver ??= $this->defaultCharRevolver();
    }

    protected function defaultStyleRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                [
                    new Frame('%s', 0)
                ],
                new Interval()
            );
    }

    protected function defaultCharRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                [
                    FrameFactory::createEmpty()
                ],
                new Interval()
            );
    }

    public function withStyleRevolver(IRevolver $styleRevolver): static
    {
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    public function withCharRevolver(IRevolver $charRevolver): static
    {
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
    }
}
