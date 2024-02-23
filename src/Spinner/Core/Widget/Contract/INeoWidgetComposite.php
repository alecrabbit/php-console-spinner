<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\IPlaceholder;

interface INeoWidgetComposite extends IWidget,
                                      IObserver
{
    public function add(IWidget $widget, ?IPlaceholder $placeholder = null): IPlaceholder;

    public function remove(IPlaceholder|IWidget $item): void;
}
