<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\A\ARevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    protected ?IRevolver $styleRevolver = null;
    protected ?IRevolver $charRevolver = null;

    /** @inheritdoc */
    public function build(): IRevolver
    {
        $this->validate();

        return
            new WidgetRevolver(
                $this->styleRevolver,
                $this->charRevolver,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->styleRevolver => throw new LogicException('Style revolver is not set.'),
            null === $this->charRevolver => throw new LogicException('Character revolver is not set.'),
            default => null,
        };
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
}
