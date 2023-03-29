<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use Traversable;

interface ISpinnerConfig
{
    public function isEnabledInitialization(): bool;

    public function getInterval(): IInterval;
}