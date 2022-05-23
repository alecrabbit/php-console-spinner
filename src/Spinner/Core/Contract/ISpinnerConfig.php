<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ISpinnerConfig
{
    public function isAsynchronous(): bool;

    public function isSynchronous(): bool;

    public function getLoop(): ILoop;

    public function getShutdownDelay(): int|float;

    public function getExitMessage(): string;

    public function getSpinnerClass(): string;

//    public function getSequencer(): ISequencer;

//    public function getWriter(): IWriter;

    public function getInterval(): int|float;

//    public function getRenderer(): IRenderer;

    public function getDriver(): IDriver;
}
