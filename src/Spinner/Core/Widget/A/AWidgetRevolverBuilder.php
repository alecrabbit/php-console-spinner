<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;

abstract class AWidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    protected ?IRevolver $styleRevolver = null;
    protected ?IRevolver $charRevolver = null;
    protected ?IPattern $stylePattern = null;
    protected ?IPattern $charPattern = null;


    /** @inheritdoc */
    public function build(): IRevolver
    {
        $this->processPatterns();

        return
            new WidgetRevolver(
                $this->styleRevolver ?? $this->getRevolverFactory()->defaultStyleRevolver(),
                $this->charRevolver ?? $this->getRevolverFactory()->defaultCharRevolver(),
            );
    }

    protected function processPatterns(): void
    {
        if ($this->stylePattern) {
            $this->styleRevolver ??=
                $this->getRevolverFactory()
                    ->create(
                        $this->stylePattern
                    )
            ;
        }

        if ($this->charPattern) {
            $this->charRevolver ??=
                $this->getRevolverFactory()
                    ->create(
                        $this->charPattern
                    )
            ;
        }
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

    public function withStylePattern(IPattern $stylePattern): static
    {
        $clone = clone $this;
        $clone->stylePattern = $stylePattern;
        return $clone;
    }

    public function withCharPattern(IPattern $charPattern): static
    {
        $clone = clone $this;
        $clone->charPattern = $charPattern;
        return $clone;
    }
}
