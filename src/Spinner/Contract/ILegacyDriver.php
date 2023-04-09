<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ILegacyDriver
{
    public function elapsedTime(): float;

    public function erase(): void;

    public function display(): void;

    public function setCurrentFrame(IFrame $frame): void;

    public function interrupt(?string $interruptMessage = null): void;

    public function finalize(?string $finalMessage = null): void;

    public function initialize(): void;
}
