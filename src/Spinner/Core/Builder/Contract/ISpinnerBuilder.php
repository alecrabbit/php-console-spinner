<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

interface ISpinnerBuilder
{
    public function build(): ISpinner;

    public function withWidget(IWidget $widget): ISpinnerBuilder;

    public function withObserver(IObserver $observer): ISpinnerBuilder;
}