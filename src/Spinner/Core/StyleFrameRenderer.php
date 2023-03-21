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

final class StyleFrameRenderer extends AFrameRenderer
{
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
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function createFromInt(int $entry): IFrame
    {
        $this->assertEntryInt($entry);
        return
            match ($this->patternColorMode) {
                ColorMode::ANSI4 => throw new LogicException('Not implemented yet.'),
                ColorMode::ANSI8 => FrameFactory::create(
                    Sequencer::colorSequence(sprintf('38;5;%sm', (string)$entry) . '%s'),
                    0
                ),
                default => throw new LogicException(
                    sprintf('Unsupported color mode %s.', $this->patternColorMode->name)
                ),
            };
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertEntryInt(int $entry): void
    {
        match (true) {
            0 > $entry => throw new InvalidArgumentException(
                sprintf(
                    'Value should be positive integer, %d given.',
                    $entry
                )
            ),
            $this->patternColorMode === ColorMode::ANSI24 => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode rendering from int is not allowed.',
                    ColorMode::class,
                    ColorMode::ANSI24->name
                )
            ),
            $this->patternColorMode === ColorMode::ANSI8 && 255 < $entry => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..255, %d given.',
                    ColorMode::class,
                    ColorMode::ANSI8->name,
                    $entry
                )
            ),
            $this->patternColorMode === ColorMode::ANSI4 && 17 < $entry => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..15, %d given.',
                    ColorMode::class,
                    ColorMode::ANSI4->name,
                    $entry
                )
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function createFromString(string $entry, bool $bg = false): IFrame
    {
        $this->assertEntryString($entry);

        if ($this->terminalColorMode === ColorMode::NONE) {
            return FrameFactory::create('%s', 0);
        }

        $color = $this->terminalColorMode->ansiCode($entry);
//        $color = sprintf('8;5;%sm', $entry);

        return
            FrameFactory::create(
                Sequencer::colorSequence(($bg ? '4' : '3') . $color . 'm%s'),
                0
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertEntryString(string $entry): void
    {
        $strlen = strlen($entry);
        match (true) {
            0 === $strlen => throw new InvalidArgumentException(
                'Value should not be empty string.'
            ),
            !str_starts_with($entry, '#') => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. No "#" found.',
                    $entry
                )
            ),
            4 !== $strlen && 7 !== $strlen => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. Length: %d.',
                    $entry,
                    $strlen
                )
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function createFromArray(array $entry): IFrame
    {
        $this->assertEntryArray($entry);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertEntryArray(array $entry): void
    {
        throw new InvalidArgumentException(
            'Tmp.'
        );
    }
}
