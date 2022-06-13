<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

interface IWidget
{
    public function render(): AWidgetFrame;

    public function add(IWidget $widget): static;

    public function remove(IWidget $widget): static;

    public function parent(?IWidget $widget): void;

    public function isComposite(): bool;
}
