<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class WidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    private ?IFrameRevolver $styleRevolver = null;
    private ?IFrameRevolver $charRevolver = null;
    private ?ITolerance $tolerance = null;

    public function build(): IWidgetRevolver
    {
        $this->validate();

        return
            new WidgetRevolver(
                $this->styleRevolver,
                $this->charRevolver,
                $this->tolerance,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->styleRevolver => throw new LogicException('Style revolver is not set.'),
            $this->charRevolver === null => throw new LogicException('Character revolver is not set.'),
            $this->tolerance === null => throw new LogicException('Tolerance is not set.'),
            default => null,
        };
    }

    public function withStyleRevolver(IFrameRevolver $styleRevolver): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    public function withCharRevolver(IFrameRevolver $charRevolver): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
    }

    public function withTolerance(ITolerance $tolerance): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
