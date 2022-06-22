<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Frame\Contract;

interface ICharFrame
{
    public static function createEmpty(): static;

    public function getChar(): string;

    public function getWidth(): int;
}
