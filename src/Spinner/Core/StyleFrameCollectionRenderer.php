<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Contract\IColorConverter;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\A\AFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

final class StyleFrameCollectionRenderer extends AFrameCollectionRenderer
{
    private const FG = 'fg';
    private const BG = 'bg';
    private const COLOR_ARRAY_SIZE = 2;

    private ColorMode $patternColorMode = ColorMode::NONE;
    private ColorMode $colorMode;

    public function __construct(
        protected IAnsiColorConverter $converter,
        protected ColorMode $terminalColorMode,
    ) {
        $this->colorMode = $this->calculateColorMode();
    }

    protected function calculateColorMode(): ColorMode
    {
        return $this->patternColorMode->lowest($this->terminalColorMode);
    }

    /** @inheritdoc */
    public function pattern(IPattern $pattern): IFrameCollectionRenderer
    {
        if (!$pattern instanceof IStylePattern) {
            throw new InvalidArgumentException(
                sprintf(
                    'Pattern should be instance of %s, %s given.',
                    IStylePattern::class,
                    get_debug_type($pattern)
                )
            );
        }

        $clone = clone $this;
        $clone->pattern = $pattern;
        $clone->patternColorMode = $pattern->getColorMode();
        $clone->colorMode = $clone->calculateColorMode();
        return $clone;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function createFrame(int|string|array $entry, bool $bg = false): IFrame
    {
        if ($this->terminalColorMode === ColorMode::NONE) {
            return FrameFactory::create('%s', 0);
        }

        if (is_array($entry)) {
            return $this->createFromArray($entry);
        }

        $ansiCode = $this->converter->ansiCode($entry, $this->colorMode);

        $color = ($bg ? '4' : '3') . $ansiCode . 'm%s';

        return
            FrameFactory::create(Sequencer::colorSequence($color), 0);
    }

    /**
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function createFromArray(array $entry): IFrame
    {
        $this->assertEntryArray($entry);

        $fgColor = $this->converter->ansiCode((string)$entry[self::FG], $this->colorMode);
        $bgColor = $this->converter->ansiCode((string)$entry[self::BG], $this->colorMode);

        return
            FrameFactory::create(
                Sequencer::colorSequence('3' . $fgColor . ';4' . $bgColor . 'm%s'),
                0
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertEntryArray(array $entry): void
    {
        $size = count($entry);
        $expectedSize = 2;
        if (self::COLOR_ARRAY_SIZE !== $size) {
            throw new InvalidArgumentException(
                sprintf(
                    'Array should contain %d elements, %d given.',
                    $expectedSize,
                    $size
                )
            );
        }
        if (!array_key_exists(self::FG, $entry) || !array_key_exists(self::BG, $entry)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Array should contain keys "%s" and "%s", keys ["%s"] given.',
                    self::FG,
                    self::BG,
                    implode('", "', array_keys($entry))
                )
            );
        }
    }

//    /**
//     * @throws LogicException
//     * @throws InvalidArgumentException
//     */
//    protected function doCreate(int|string|array $entry, bool $bg = false): IFrame
//    {
//        if ($this->terminalColorMode === ColorMode::NONE) {
//            return FrameFactory::create('%s', 0);
//        }
//
//        $color = $this->converter->ansiCode($entry, $this->colorMode);
//
//        return
//            FrameFactory::create(
//                Sequencer::colorSequence(($bg ? '4' : '3') . $color . 'm%s'),
//                0
//            );
//    }
}
