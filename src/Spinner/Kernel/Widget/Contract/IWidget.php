<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Kernel\Widget\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ACharFrame;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;

interface IWidget
{
    public function render(?IWInterval $interval = null): ACharFrame;

    public function add(IWidget $widget): static;

    public function remove(IWidget $widget): static;

    public function parent(?IWidget $widget): void;

    public function isComposite(): bool;
}
