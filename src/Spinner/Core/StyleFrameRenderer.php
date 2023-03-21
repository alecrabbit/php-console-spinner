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

    protected function createFromStringInt(int|string $entry, bool $bg = false): IFrame
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
