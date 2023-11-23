<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Spinner\Exception\LogicException;

interface IDriverBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IDriver;

    public function withInitialInterval(IInterval $interval): IDriverBuilder;

    public function withDeltaTimer(IDeltaTimer $timer): IDriverBuilder;

    public function withObserver(IObserver $observer): IDriverBuilder;

    public function withIntervalComparator(IIntervalComparator $intervalComparator): IDriverBuilder;

    public function withDriverMessages(IDriverMessages $driverMessages): IDriverBuilder;

    public function withRenderer(IRenderer $renderer): IDriverBuilder;
}
