<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;

interface IConfig
{
    public function isAsynchronous(): bool;

    public function isSynchronous(): bool;

    public function forMultiSpinner(): bool;

    public function getLoop(): ILoop;

    public function getShutdownDelay(): int|float;

    public function getInterruptMessage(): string;

    public function getDriver(): IDriver;

    public function getColorSupportLevel(): int;

    public function getFinalMessage(): string;

    public function getContainer(): IContainer;

    public function getTwirlerFactory(): ITwirlerFactory;

    public function getStyleFrameCollectionFactory(): IStyleFrameCollectionFactory;

    public function getCharFrameCollectionFactory(): ICharFrameCollectionFactory;

    public function getTwirlerBuilder(): ITwirlerBuilder;
}
