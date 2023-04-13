<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class StyleRenderer implements IStyleRenderer
{
    public function __construct(
        protected IAnsiStyleConverter $converter,
        protected ISequencer $sequencer,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $style, OptionStyleMode $mode): string
    {
        if ($style->isEmpty()) {
            throw new InvalidArgumentException('Style is empty.');
        }

        if ($mode === OptionStyleMode::NONE) {
            return $style->getFormat();
        }

//        return $style->getFormat();
        return
            dump(
                $this->sequencer->colorSequence(
                    '3' .
                    $this->converter->ansiCode($style->getFgColor(), $mode) . 'm' .
                    $style->getFormat()
                )
            );
    }
}
