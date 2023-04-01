<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class AFrameRevolverBuilder extends ARevolverBuilder implements IFrameRevolverBuilder
{
    protected ?IPattern $pattern = null;

    public function __construct(
        protected IStyleFrameCollectionRenderer $styleFrameCollectionRenderer,
        protected ICharFrameCollectionRenderer $charFrameCollectionRenderer,
    ) {
    }

    public function withPattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->pattern = $pattern;
        return $clone;
    }

    public function build(): IFrameRevolver
    {
        self::assertPattern($this->pattern);

        if ($this->pattern instanceof IStylePattern) {
            return
                new FrameCollectionRevolver(
                    $this->styleFrameCollectionRenderer
                        ->pattern($this->pattern)
                        ->render(),
                    $this->pattern->getInterval()
                );
        }
        return
            new FrameCollectionRevolver(
                $this->charFrameCollectionRenderer
                    ->pattern($this->pattern)
                    ->render(),
                $this->pattern->getInterval()
            );
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
}
