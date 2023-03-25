<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

abstract class AStyleFrameRenderer extends AFrameRenderer implements IStyleFrameRenderer
{
    public function __construct(
        protected IAnsiStyleConverter $converter,
        // TODO: should it be composed with FrameRenderer? [68a233da-988c-4474-b34b-6e0fb75792cc]
    ) {
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function render(string|IStyle $entry, StyleMode $styleMode = StyleMode::NONE): IFrame
    {
        if (!$this->converter->isEnabled()) {
            return
                FrameFactory::create('%s', 0);
        }
        return $this->createFrame($entry, $styleMode);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function createFrame(string|IStyle $entry, StyleMode $colorMode): IFrame
    {
        if ($entry instanceof IStyle) {
            return $this->createFromStyle($entry, $colorMode);
        }
        $ansiCode = $this->converter->ansiCode($entry, $colorMode);

        $color = '3' . $ansiCode . 'm' . '%s';

        return
            FrameFactory::create(Sequencer::colorSequence($color), 0);
    }

    protected function createFromStyle(IStyle $entry, StyleMode $colorMode): IFrame
    {
        $fgColor = $entry->getFgColor();
        $bgColor = $entry->getBgColor();
        $color = '';
        if (null !== $fgColor) {
            $color .= '3' . $this->converter->ansiCode((string)$fgColor, $colorMode);
        }
        if (null !== $bgColor) {
            $color .= ';4' . $this->converter->ansiCode((string)$bgColor, $colorMode);
        }
        $color .= 'm%s';
        return
            FrameFactory::create(Sequencer::colorSequence($color), $entry->getWidth());
    }

    public function isStyleEnabled(): bool
    {
        return $this->converter->isEnabled();
    }
}