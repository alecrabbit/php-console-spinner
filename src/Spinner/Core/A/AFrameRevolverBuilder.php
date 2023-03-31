<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Core\Widget\A\ARevolverBuilder;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class AFrameRevolverBuilder extends ARevolverBuilder implements IFrameRevolverBuilder
{
    protected ?IPattern $pattern = null;

    public function withPattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->pattern = $pattern;
        return $clone;
    }

    public function build(): IFrameRevolver
    {
        self::assertPattern($this->pattern);

//        $defaultsProvider = $this->getDefaultsProvider();
//        $colorMode = OptionStyleMode::ANSI8; // FIXME this is a hardcode

        if ($this->pattern instanceof IStylePattern) {
            return
                new FrameCollectionRevolver(
                    $this->getStyleFrameCollectionRenderer()
                        ->pattern($this->pattern)
                        ->render(),
                    $this->pattern->getInterval()
                );
        }
        return
            new FrameCollectionRevolver(
                $this->getCharFrameCollectionRenderer()
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

    private function getStyleFrameCollectionRenderer(): IFrameCollectionRenderer
    {
        return
            new StyleFrameCollectionRenderer(
                new StyleFrameRenderer($this->getColorConverter()),
            );
    }

    private function getCharFrameCollectionRenderer(): CharFrameCollectionRenderer
    {
        return
            new CharFrameCollectionRenderer();
    }

}
