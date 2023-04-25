<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

interface IWidgetContextContainer
{
    public function add(IWidgetContext $context): IWidgetContext;

    public function remove(IWidgetContext $context): void;

    public function get(IWidgetContext $context);

    public function find(IWidget $widget): IWidgetContext;
}
