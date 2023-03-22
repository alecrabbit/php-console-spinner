<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IDriver
{
    public function elapsedTime(): float;

    public function erase(IFrame $frame): void;

    public function display(IFrame $frame): void;

    public function interrupt(?string $interruptMessage = null): void;

    public function finalize(?string $finalMessage = null): void;

    public function initialize(): void;
}
