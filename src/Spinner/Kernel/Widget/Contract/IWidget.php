<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Kernel\Widget\Contract;

use AlecRabbit\Spinner\Kernel\Contract\ACharFrame;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IInterval;

interface IWidget
{
    public function render(?IInterval $interval = null): ACharFrame;

    public function add(IWidget $widget): static;

    public function remove(IWidget $widget): static;

    public function parent(?IWidget $widget): void;

    public function isComposite(): bool;
}
