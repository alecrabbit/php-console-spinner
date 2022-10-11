<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface ISimpleSpinner
{
    public function spinner(ITwirler|null $value): void;

    public function progress(ITwirler|IProgress $value): void;

    public function message(ITwirler|IMessage $value): void;
}
