<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/** @psalm-suppress UnusedClass */
final class ProgressBarProcedure extends AProgressValueProcedure
{
    protected const UNITS = 5;
    protected string $open;
    protected string $close;
    protected string $empty;
    protected string $done;
    protected string $cursor;
    protected float $cursorThreshold;

    public function __construct(
        IProgressValue $progressValue,
        protected ?IProgressBarSprite $sprite = null,
        protected int $units = self::UNITS,
        protected bool $withCursor = true,
    ) {
        parent::__construct($progressValue);

        $this->init();
    }

    protected function init(): void
    {
        $this->cursorThreshold = $this->progressValue->getMax();
        $this->units = $this->withCursor ? $this->units - 1 : $this->units;
        $this->open = $this->sprite ? $this->sprite->getOpen() : '[';
        $this->close = $this->sprite ? $this->sprite->getClose() : ']';
        $this->empty = $this->sprite ? $this->sprite->getEmpty() : '-';
        $this->done = $this->sprite ? $this->sprite->getDone() : '=';
        $this->cursor = $this->sprite ? $this->sprite->getCursor() : '>';
    }

    private function getCursor(float $fraction): string
    {
        return $fraction >= $this->cursorThreshold
            ? $this->done
            : $this->cursor;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt ?? 0.0;
        }
        $v = $this->createBar($this->progressValue->getValue());
        return CharFrameFactory::create($v);
    }

    private function createBar(float $progress): string
    {
        $p = (int)($progress * $this->units);

        $cursor =
            $this->withCursor
                ? $this->getCursor($progress)
                : '';

        return $this->open .
            str_repeat($this->done, $p) .
            $cursor .
            str_repeat($this->empty, $this->units - $p) .
            $this->close;
    }
}
