<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @deprecated
 */
final class OldStyleFrameRenderer extends AFrameRenderer
{
    private const FG = 'fg';
    private const BG = 'bg';
    private const COLOR_ARRAY_SIZE = 2;

    private ColorMode $patternColorMode;
    private ColorMode $terminalColorMode;

    public function __construct(
        IStylePattern $pattern
    ) {
        $this->patternColorMode = $pattern->getColorMode();
        $this->terminalColorMode = self::getDefaults()->getTerminalSettings()->getColorMode();
        parent::__construct($pattern);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function createFrame(int|string $entry, bool $bg = false): IFrame
    {
        if ($this->terminalColorMode === ColorMode::NONE) {
            return FrameFactory::create('%s', 0);
        }

        $color = $this->patternColorMode->simplest($this->terminalColorMode)->ansiCode($entry);

        return
            FrameFactory::create(
                Sequencer::colorSequence(($bg ? '4' : '3') . $color . 'm%s'),
                0
            );
    }

    /**
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function createFromArray(array $entry): IFrame
    {
        $this->assertEntryArray($entry);

        if ($this->terminalColorMode === ColorMode::NONE) {
            return FrameFactory::create('%s', 0);
        }

        $fgColor = $this->patternColorMode->simplest($this->terminalColorMode)->ansiCode((string)$entry[self::FG]);
        $bgColor = $this->patternColorMode->simplest($this->terminalColorMode)->ansiCode((string)$entry[self::BG]);

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
}
