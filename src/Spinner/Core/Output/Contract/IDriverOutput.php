<?php
declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IDriverOutput
{
    public function finalize(?string $finalMessage = null): void;

    public function initialize(): void;

    public function erase(int $width): void;

    public function writeSequence(string $sequence, int $width, int $previousWidth): void;
}
