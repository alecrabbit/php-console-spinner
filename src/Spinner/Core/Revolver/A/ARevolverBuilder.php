<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\FramesRenderer;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\ProceduralRevolver;
use AlecRabbit\Spinner\Core\StyleFramesRenderer;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class ARevolverBuilder implements IRevolverBuilder
{
    protected ?IPattern $pattern = null;

    public function withPattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->pattern = $pattern;
        return $clone;
    }

    public function build(): IRevolver
    {
        if (!$this->pattern) {
            throw new DomainException(sprintf('%s: Pattern is not set.', static::class));
        }
        return $this->buildRevolver();
    }

    protected function buildRevolver(): IRevolver
    {
        if ($this->pattern instanceof IProceduralPattern) {
            return
                new ProceduralRevolver(
                    $this->pattern->getPattern(),
                    $this->pattern->getInterval()
                );
        }
        if ($this->pattern instanceof IStylePattern) {
            return
                new FrameCollectionRevolver(
                    (new StyleFramesRenderer($this->pattern))->render(),
                    $this->pattern->getInterval()
                );
        }
        return
            new FrameCollectionRevolver(
                (new FramesRenderer($this->pattern))->render(),
                $this->pattern->getInterval()
            );
    }
}