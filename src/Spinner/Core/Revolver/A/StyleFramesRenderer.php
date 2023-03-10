<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

use const AlecRabbit\Spinner\CSI;
use const AlecRabbit\Spinner\RESET;

final class StyleFramesRenderer extends AFramesRenderer
{
    public function __construct(
        IStylePattern $pattern
    ) {
        parent::__construct($pattern);
    }

    /** @inheritdoc */
    protected function createFrame(mixed $entry): IFrame
    {
        $colorMode = self::getDefaults()->getTerminal()->getColorMode();

        return new Frame(CSI . sprintf('38;5;%sm', $entry) . '%s' . RESET, 0);
    }
}