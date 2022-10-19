<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Contract;

interface IStyleFrame
{
    public static function createEmpty(): static;

    public function getStyleSequenceStart(): string;

    public function getStyleSequenceEnd(): string;
}
