<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

interface IHasWidgetContext
{
    public function getContext(): IWidgetContext;

    public function replaceContext(IWidgetContext $context): void;
}