<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
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
        return
            new WidgetRevolver(
                $this->styleRevolver ?? RevolverFactory::defaultStyleRevolver(),
                $this->charRevolver ?? RevolverFactory::defaultCharRevolver(),
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
