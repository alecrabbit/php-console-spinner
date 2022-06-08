<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ISpinner
{
    public function __construct(ISpinnerConfig $config);

    public function refreshInterval(): int|float;

    public function isSynchronous(): bool;

    public function isAsynchronous(): bool;

    public function spin(): void;

    public function begin(): void;

    public function end(): void;

    public function erase(): void;

    public function disable(): void;

    public function enable(): void;

    public function spinner(IRevolveWiggler|string|null $spinner): void;

    public function message(IMessageWiggler|string|null $message): void;

    public function progress(IProgressWiggler|float|null $progress): void;
}
