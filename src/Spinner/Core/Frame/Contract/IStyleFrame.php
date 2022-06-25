<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Contract;

interface IStyleFrame
{
    public static function createEmpty(): static;

    public function getSequenceStart(): string;

    public function getSequenceEnd(): string;
}
