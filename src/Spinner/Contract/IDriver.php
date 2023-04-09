<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Contract;

interface IDriver extends IRenderable, HasInterval
{
    public function render(float $dt = null): void;

//    public function erase(?ISpinner $spinner = null): void; // TODO Does it belong here?

    public function interrupt(?string $interruptMessage = null): void;

    public function finalize(?string $finalMessage = null): void;

    public function initialize(): void;

//    public function getWrapper(ISpinner $spinner): IWrapper; // TODO Does it belong here?
}
