<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\HasInterval;
use AlecRabbit\Spinner\Contract\IRenderable;
use AlecRabbit\Spinner\Contract\IWrapper;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ILegacySpinner extends IRenderable, IWrapper, HasInterval
{
    public function spin(float $dt = null): void;

    public function initialize(): void;

    public function interrupt(string $interruptMessage = null): void;

    public function finalize(string $finalMessage = null): void;

    public function erase(): void;

    public function deactivate(): void;

    public function activate(): void;

    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext;

    public function remove(IWidgetComposite|IWidgetContext $element): void;
}
