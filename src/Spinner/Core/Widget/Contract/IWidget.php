<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface IWidget
{
    public function render(?IInterval $interval = null): AWigglerFrame;

    public function add(IWidget $widget): static;

    public function remove(IWidget $widget): static;

    public function parent(?IWidget $widget): void;

    public function isComposite(): bool;
}
