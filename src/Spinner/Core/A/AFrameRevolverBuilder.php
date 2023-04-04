<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class AFrameRevolverBuilder extends ARevolverBuilder implements IFrameRevolverBuilder
{
    protected ?IPattern $pattern = null;
    protected ?IFrameCollection $frames = null;
    protected ?IInterval $interval = null;

    public function __construct(
        protected IStyleFrameCollectionRenderer $styleFrameCollectionRenderer,
        protected ICharFrameCollectionRenderer $charFrameCollectionRenderer,
        protected IIntervalFactory $intervalFactory,
    ) {
    }

    public function withPattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->pattern = $pattern;
        return $clone;
    }

    public function withInterval(IInterval $interval): static
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function defaultCharRevolver(): IRevolver
    {
        return
            $this
                ->withFrameCollection(
                    $this->charFrameCollectionRenderer->defaultCollection()
                )
                ->build()
        ;
    }

    public function build(): IFrameRevolver
    {
        $this->processValues();

        return
            new FrameCollectionRevolver($this->frames, $this->interval);
    }

    protected function processValues(): void
    {
        if (null === $this->frames) {
            self::assertPattern($this->pattern);
            $this->frames = $this->renderFrames($this->pattern);
            if (null === $this->interval) {
                $this->interval = $this->pattern->getInterval();
            }
        }
        if (null === $this->interval) {
            $this->interval = $this->intervalFactory->createStill();
        }
    }

    /**
     * @throws DomainException
     */
    protected static function assertPattern(?IPattern $pattern): void
    {
        if (null === $pattern) {
            throw new DomainException('Pattern is not set.');
        }
    }

    protected function renderFrames(IPattern $pattern): IFrameCollection
    {
        if ($pattern instanceof IStylePattern) {
            return
                $this->styleFrameCollectionRenderer
                    ->pattern($pattern)
                    ->render()
            ;
        }
        return
            $this->charFrameCollectionRenderer
                ->pattern($pattern)
                ->render()
        ;
    }

    protected function withFrameCollection(IFrameCollection $frames): static
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function defaultStyleRevolver(): IRevolver
    {
        return
            $this
                ->withFrameCollection(
                    $this->styleFrameCollectionRenderer->defaultCollection()
                )
                ->build()
        ;
    }
}
