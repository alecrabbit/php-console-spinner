<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\A\ARevolverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;

final class WidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    protected ?IRevolver $styleRevolver = null;
    protected ?IRevolver $charRevolver = null;
    protected ?IPattern $stylePattern = null;
    protected ?IPattern $charPattern = null;

    public function __construct(
        protected IRevolverFactory $revolverFactory,
    ) {
    }

    /** @inheritdoc */
    public function build(): IRevolver
    {
        $this->processPatterns();

        return
            new WidgetRevolver(
                $this->styleRevolver ?? $this->revolverFactory->defaultStyleRevolver(),
                $this->charRevolver ?? $this->revolverFactory->defaultCharRevolver(),
            );
    }

    protected function processPatterns(): void
    {
        if ($this->stylePattern) {
            $this->styleRevolver ??=
                $this->revolverFactory
                    ->create(
                        $this->stylePattern
                    );
        }

        if ($this->charPattern) {
            $this->charRevolver ??=
                $this->revolverFactory
                    ->create(
                        $this->charPattern
                    );
        }
    }

    public function withStyleRevolver(IRevolver $styleRevolver): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    public function withCharRevolver(IRevolver $charRevolver): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
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
