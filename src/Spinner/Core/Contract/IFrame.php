<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IFrame
{
    public static function createEmpty(): static;

    public static function createSpace(): static;

    public function sequence(): string;

    public function width(): int;
}