<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

interface ITwirlerContainer extends CanAddTwirler
{
    public function render(): iterable;
}
