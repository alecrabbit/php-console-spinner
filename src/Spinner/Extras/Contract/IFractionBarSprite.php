<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

interface IFractionBarSprite
{
    public function getOpen(): string;

    public function getClose(): string;

    public function getEmpty(): string;

    public function getDone(): string;

    public function getCursor(): string;
}
