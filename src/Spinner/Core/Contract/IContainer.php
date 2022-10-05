<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;

interface IContainer extends IIntervalComponent
{
    public function render(): iterable;

    public function getIntervalVisitor(): IIntervalVisitor;

    public function getCycleVisitor(): ICycleVisitor;

    public function add(ITwirler $twirler): ITwirlerContext;

    public function remove(ITwirlerContext|ITwirler $element): void;

    public function spinner(ITwirler $twirler): void;

    public function progress(ITwirler $twirler): void;

    public function message(ITwirler $twirler): void;

    public function wasCreatedEmpty(): bool;
}
