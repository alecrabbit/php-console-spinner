<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AFrame;

interface IWidget
{
    public function render(?IInterval $interval = null): AFrame;

    public function add(IWidget $widget): static;

    public function remove(IWidget $widget): static;

    public function parent(?IWidget $widget): void;

    public function isComposite(): bool;
}
