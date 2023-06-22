<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasNullableInterval;
use AlecRabbit\Spinner\Contract\ICanBeEmpty;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use Countable;
use IteratorAggregate;

interface IWidgetCompositeChildrenContainer extends ISubject,
                                                    IObserver,
                                                    ICanBeEmpty,
                                                    IHasNullableInterval,
                                                    Countable,
                                                    IteratorAggregate
{
    public function add(IWidgetContext $context): IWidgetContext;

    public function remove(IWidgetContext $context): void;

    public function has(IWidgetContext $context): bool;
}
