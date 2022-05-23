<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IRotator
{
    public function __construct(ISpinnerConfig $config);

    public function refreshInterval(): int|float;

    public function isSynchronous(): bool;

    public function isAsynchronous(): bool;

    public function rotate(): void;

    public function begin(): void;

    public function end(): void;

    public function erase(): void;

    public function disable(): void;

    public function enable(): void;

    public function spinner(null|ISpinner $spinner): void;

    public function message(null|string|IMessage $message): void;

    public function progress(null|float|IProgress $progress): void;
}
