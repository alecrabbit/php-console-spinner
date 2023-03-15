<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFramesRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

final class StyleFramesRenderer extends AFramesRenderer
{
    private const ESC = "\033";
    private const CSI = self::ESC . '[';
    private const RESET = self::CSI . '0m';

    public function __construct(
        IStylePattern $pattern
    ) {
        parent::__construct($pattern);
    }

    /** @inheritdoc */
    protected function createFrame(mixed $entry): IFrame
    {
        $colorMode = self::getDefaults()->getTerminalSettings()->getColorMode();

        return
            FrameFactory::create(
                self::CSI . sprintf('38;5;%sm', $entry) . '%s' . self::RESET,
                0
            );
    }
}