<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IFrame
{
    public function sequence(): string;

    public function width(): int;

    public static function createEmpty(): IFrame;

    public static function createSpace(): IFrame;
}
