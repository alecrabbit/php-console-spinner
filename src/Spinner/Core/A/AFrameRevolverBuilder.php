<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Contract\IColorConverter;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Widget\A\ARevolverBuilder;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class AFrameRevolverBuilder extends ARevolverBuilder implements IFrameRevolverBuilder
{
    protected ?IPattern $pattern = null;

    public function __construct(
        IDefaults $defaults,
        protected IAnsiColorConverter $colorConverter,
    ) {
        parent::__construct($defaults);
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

        $colorMode = $this->defaults->getTerminalSettings()->getColorMode();

        if ($this->pattern instanceof IStylePattern) {
            return
                new FrameCollectionRevolver(
                    (new StyleFrameCollectionRenderer($this->colorConverter, $colorMode))
                        ->pattern($this->pattern)
                        ->render(),
                    $this->pattern->getInterval()
                );
        }
        return
            new FrameCollectionRevolver(
                (new CharFrameCollectionRenderer())->pattern($this->pattern)->render(),
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