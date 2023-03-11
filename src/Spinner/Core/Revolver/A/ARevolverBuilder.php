<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\FramesRenderer;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AProceduralStylePattern;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\ProceduralRevolver;
use AlecRabbit\Spinner\Core\StyleFramesRenderer;
use AlecRabbit\Spinner\Exception\DomainException;

// TODO should this class be a factory?
// FIXME class has a dependency on Procedural functionality

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
            $revolver = new ProceduralRevolver(
                $this->pattern->getProcedure(),
                $this->pattern->getInterval()
            );
            if ($this->pattern instanceof AProceduralStylePattern) {
                self::assertIsStylePattern($revolver);
            }
            return
                $revolver;
        }
        if ($this->pattern instanceof IStylePattern) {
            $revolver = new FrameCollectionRevolver(
                (new StyleFramesRenderer($this->pattern))->render(),
                $this->pattern->getInterval()
            );
            self::assertIsStylePattern($revolver);
            return
                $revolver;
        }
        return
            new FrameCollectionRevolver(
                (new FramesRenderer($this->pattern))->render(),
                $this->pattern->getInterval()
            );
    }

    /**
     * @throws DomainException
     */
    protected static function assertIsStylePattern(IRevolver $revolver): void
    {
        // assert that revolver output has '%s' placeholder in Frame sequence of first frame
        $frame = $revolver->update();
        if (!str_contains($frame->sequence(), '%s')) {
            throw new DomainException(
                sprintf(
                    '%s: Revolver output has no \'%%s\' placeholder in Frame sequence.',
                    static::class
                )
            );
        }
    }
}