<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Procedure\A;

use AlecRabbit\Spinner\Core\Procedure\Contract\IFractionBarSprite;

abstract readonly class AFractionBarSprite implements IFractionBarSprite
{
    public function __construct(
        protected string $empty = '░',
        protected string $done = '█',
        protected string $cursor = '▓',
        protected string $open = '',
        protected string $close = '',
    ) {
    }

    public function getEmpty(): string
    {
        return $this->empty;
    }

    public function getDone(): string
    {
        return $this->done;
    }

    public function getCursor(): string
    {
        return $this->cursor;
    }

    public function getOpen(): string
    {
        return $this->open;
    }

    public function getClose(): string
    {
        return $this->close;
    }

}
