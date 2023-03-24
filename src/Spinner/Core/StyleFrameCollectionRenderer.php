<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Core\A\AFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use ArrayObject;

final class StyleFrameCollectionRenderer extends AFrameCollectionRenderer
{
    private ColorMode $colorMode = ColorMode::NONE;

    public function __construct(
        protected IAnsiColorConverter $converter,
    ) {
    }

    /** @inheritdoc */
    public function pattern(IPattern $pattern): IFrameCollectionRenderer
    {
        if (!$pattern instanceof IStylePattern) {
            throw new InvalidArgumentException(
                sprintf(
                    'Pattern should be instance of "%s", "%s" given.',
                    IStylePattern::class,
                    get_debug_type($pattern)
                )
            );
        }

        $clone = clone $this;
        $clone->pattern = $pattern;
        $clone->colorMode = $pattern->getColorMode();
        return $clone;
    }

    /** @inheritdoc */
    public function render(): IFrameCollection
    {
        if (!$this->converter->isEnabled()) {
            return
                $this->createCollection(
                    new ArrayObject(
                        [FrameFactory::create('%s', 0)]
                    )
                );
        }
        return parent::render();
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function create(string|IStyle $entry): IFrame
    {
        if ($entry instanceof IStyle) {
            return $this->createFromStyle($entry);
        }
        $ansiCode = $this->converter->ansiCode($entry, $this->colorMode);

        $color = '3' . $ansiCode . 'm' . '%s';

        return
            FrameFactory::create(Sequencer::colorSequence($color), 0);
    }

    private function createFromStyle(IStyle $entry): IFrame
    {
        $fgColor = $entry->getFgColor();
        $bgColor = $entry->getBgColor();
        $color = '';
        if (null !== $fgColor) {
            $color .= '3' . $this->converter->ansiCode($fgColor, $this->colorMode);
        }
        if (null !== $bgColor) {
            $color .= ';4' . $this->converter->ansiCode($bgColor, $this->colorMode);
        }
        $color .= 'm%s';
        return
            FrameFactory::create(Sequencer::colorSequence($color), $entry->getWidth());
    }
}
