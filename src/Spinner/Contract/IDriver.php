<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Driver;

interface IDriver extends IRenderable, HasInterval
{
    public function add(ISpinner $spinner): void;

    public function remove(ISpinner $spinner): void;

    public function erase(ISpinner $spinner): void;

    public function initialize(): void;

    public function interrupt(?string $interruptMessage = null): void;

    public function finalize(?string $finalMessage = null): void;

//    public function getWrapper(ISpinner $spinner): IWrapper; // TODO Does it belong here?
}
