<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequencer;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class AStyleFrameRenderer implements IStyleFrameRenderer
{
    /** @var class-string<ISequencer> */
    protected string $sequencer;

    /**
     * @param IAnsiStyleConverter $converter
     * @param class-string<ISequencer> $sequencer
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected IAnsiStyleConverter $converter,
        string $sequencer = Sequencer::class,
    ) {
        Asserter::isSubClass($sequencer, ISequencer::class, __METHOD__);
        $this->sequencer = $sequencer;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function render(int|string|IStyle $entry, StyleMode $styleMode = StyleMode::NONE): IFrame
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
    protected function createFrame(int|string|IStyle $entry, StyleMode $styleMode): IFrame
    {
        if ($styleMode === StyleMode::NONE) {
            return FrameFactory::create('%s', 0);
        }

        if ($entry instanceof IStyle) {
            return $this->createFromStyle($entry, $styleMode);
        }

        $ansiCode = $this->converter->ansiCode($entry, $styleMode);

        $color = '3' . $ansiCode . 'm' . '%s';

        return
            FrameFactory::create($this->sequencer::colorSequence($color), 0);
    }

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function createFromStyle(IStyle $entry, StyleMode $styleMode): IFrame
    {
        if ($entry->isEmpty() || $entry->isOptionsOnly()) {
            return FrameFactory::create('%s', $entry->getWidth());
        }

        $color = $this->flattenStyle($entry, $styleMode);

        return
            FrameFactory::create($this->sequencer::colorSequence($color), $entry->getWidth());
    }

    /**
     * // FIXME: method has non-optimal implementation
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function flattenStyle(IStyle $entry, StyleMode $styleMode): string
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
}