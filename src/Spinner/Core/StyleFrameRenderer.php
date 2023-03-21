<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use Stringable;

final class StyleFrameRenderer extends AFrameRenderer
{
    private ColorMode $colorMode;

    public function __construct(
        IStylePattern $pattern
    ) {
        $this->colorMode = $pattern->getColorMode();
        parent::__construct($pattern);
    }

    /** @inheritdoc */
    protected function createFrame(Stringable|string|int|array $entry): IFrame
    {
        $colorMode = self::getDefaults()->getTerminalSettings()->getColorMode();

        return
            FrameFactory::create(
                Sequencer::colorSequence(sprintf('38;5;%sm', (string)$entry) . '%s'),
                0
            );
    }
}
