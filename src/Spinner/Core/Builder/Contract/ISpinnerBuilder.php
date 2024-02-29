<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

interface ISpinnerBuilder
{
    public function build(): ISpinner;

    public function withWidget(IWidget $widget): ISpinnerBuilder;

    public function withStateFactory(ISequenceStateFactory $stateFactory): ISpinnerBuilder;

    public function withObserver(IObserver $observer): ISpinnerBuilder;

    public function withInitialState(ISequenceState $state): ISpinnerBuilder;
}
