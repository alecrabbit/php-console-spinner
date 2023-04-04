<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\A\ARevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;

final class WidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    protected ?IRevolver $styleRevolver = null;
    protected ?IRevolver $charRevolver = null;
    protected ?IPattern $stylePattern = null;
    protected ?IPattern $charPattern = null;

    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
    ) {
    }

    /** @inheritdoc */
    public function build(): IRevolver
    {
        $this->processPatterns();

        return
            new WidgetRevolver(
                $this->styleRevolver ?? $this->frameRevolverBuilder->withPattern($this->stylePattern)->build(),
                $this->charRevolver ?? $this->frameRevolverBuilder->withPattern($this->charPattern)->build(),
            );
    }

    protected function processPatterns(): void
    {
        if (null === $this->styleRevolver && null === $this->stylePattern) {
            $this->styleRevolver = $this->frameRevolverBuilder->defaultStyleRevolver();
        }

        if (null === $this->charRevolver && null === $this->charPattern) {
            $this->charRevolver = $this->frameRevolverBuilder->defaultCharRevolver();
        }
    }

    public function withStylePattern(IPattern $stylePattern): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->stylePattern = $stylePattern;
        return $clone;
    }

    public function withCharPattern(IPattern $charPattern): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->charPattern = $charPattern;
        return $clone;
    }
}
