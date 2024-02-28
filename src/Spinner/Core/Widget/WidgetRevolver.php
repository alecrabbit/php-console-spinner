<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

final readonly class WidgetRevolver implements IWidgetRevolver
{
    public function __construct(
        private IHasStyleSequenceFrame $style,
        private IHasCharSequenceFrame $char,
        private IInterval $interval,
    ) {
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
    {
        $style = $this->style->getFrame($dt);
        $char = $this->char->getFrame($dt);

        return $this->createFrame(
            sprintf($style->getSequence(), $char->getSequence()),
            $style->getWidth() + $char->getWidth()
        );
    }

    private function createFrame(string $sequence, int $width): ICharSequenceFrame
    {
        return new CharSequenceFrame($sequence, $width);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
