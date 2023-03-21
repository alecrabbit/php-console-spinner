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
    private ColorMode $colorMode;

    public function __construct(
        IStylePattern $pattern
    ) {
        $this->colorMode = $pattern->getColorMode();
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
            match ($this->colorMode) {
                ColorMode::ANSI4 => throw new LogicException('Not implemented yet.'),
                ColorMode::ANSI8 => FrameFactory::create(
                    Sequencer::colorSequence(sprintf('38;5;%sm', (string)$entry) . '%s'),
                    0
                ),
                default => throw new LogicException(
                    sprintf('Unsupported color mode %s.', $this->colorMode->name)
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
            $this->colorMode === ColorMode::ANSI24 => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode rendering from int is not allowed.',
                    ColorMode::class,
                    ColorMode::ANSI24->name
                )
            ),
            $this->colorMode === ColorMode::ANSI8 && 255 < $entry => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..255, %d given.',
                    ColorMode::class,
                    ColorMode::ANSI8->name,
                    $entry
                )
            ),
            $this->colorMode === ColorMode::ANSI4 && 17 < $entry => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..16, %d given.',
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
     */
    protected function createFromString(string $entry): IFrame
    {
        $this->assertEntryString($entry);

        return
            FrameFactory::create(
                Sequencer::colorSequence(sprintf('38;5;%sm', $entry) . '%s'),
                0
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertEntryString(string $entry): void
    {
        match (true) {
            $entry === '' => throw new InvalidArgumentException(
                'Value should not be empty string.'
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
