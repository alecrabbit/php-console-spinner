<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Core\Factory\StaticRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;

abstract class AWidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    protected ?IRevolver $styleRevolver = null;
    protected ?IRevolver $charRevolver = null;


    /** @inheritdoc */
    public function build(): IRevolver
    {
        return
            new WidgetRevolver(
                $this->styleRevolver ?? StaticRevolverFactory::defaultStyleRevolver(),
                $this->charRevolver ?? StaticRevolverFactory::defaultCharRevolver(),
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
