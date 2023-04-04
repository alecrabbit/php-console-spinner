<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequencer;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

final class StyleFrameRenderer extends AFrameRenderer implements IStyleFrameRenderer
{

    public function __construct(
        protected IFrameFactory $frameFactory,
        protected IAnsiStyleConverter $converter,
        protected ISequencer $sequencer,
    ) {
        parent::__construct($frameFactory);
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function render(int|string|IStyle $entry, OptionStyleMode $styleMode = OptionStyleMode::NONE): IFrame
    {
        if ($this->isStylingDisabled()) {
            throw new LogicException('Styling is disabled.'); // should never happen
        }
        return $this->createFrame($entry, $styleMode);
    }

    public function isStylingDisabled(): bool
    {
        return $this->converter->isDisabled();
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    protected function createFrame(int|string|IStyle $entry, OptionStyleMode $styleMode): IFrame
    {
        if ($styleMode === OptionStyleMode::NONE) {
            return $this->frameFactory->create('%s', 0);
        }

        if ($entry instanceof IStyle) {
            return $this->createFromStyle($entry, $styleMode);
        }

        $ansiCode = $this->converter->ansiCode($entry, $styleMode);

        $color = '3' . $ansiCode . 'm' . '%s';

        return
            $this->sequenceFrame($color, 0);
    }

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function createFromStyle(IStyle $entry, OptionStyleMode $styleMode): IFrame
    {
        if ($entry->isEmpty() || $entry->isOptionsOnly()) {
            return $this->frameFactory->create('%s', $entry->getWidth());
        }

        $color = $this->flattenStyle($entry, $styleMode);
        return
            $this->sequenceFrame($color, $entry->getWidth());
    }

    /**
     * // FIXME: method has non-optimal implementation
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function flattenStyle(IStyle $entry, OptionStyleMode $styleMode): string
    {
        $fgColor = $entry->getFgColor();
        $bgColor = $entry->getBgColor();
        $color = '';
        if (null !== $fgColor) {
            $color .= '3' . $this->converter->ansiCode((string)$fgColor, $styleMode);
        }
        if (null !== $bgColor) {
            $separator = null !== $fgColor ? ';' : '';
            $color .= $separator . '4' . $this->converter->ansiCode((string)$bgColor, $styleMode);
        }
        $color .= 'm%s';
        return $color;
    }

    /**
     * FIXME rename method
     */
    protected function sequenceFrame(string $color, int $width): IFrame
    {
        return
            $this->frameFactory->create($this->sequencer->colorSequence($color), $width);
    }

    public function emptyFrame(): IFrame
    {
        return $this->frameFactory->create('%s', 0);
    }
}
