<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;

interface ISpinner
{
    public function __construct(ISpinnerConfig $config);

    public function refreshInterval(): IInterval;

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
