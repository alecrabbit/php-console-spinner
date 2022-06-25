<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface ISpinner
{
    public function spinner(ITwirler|string|null $twirler): void;

    public function progress(ITwirler|string|float|null $twirler): void;

    public function message(ITwirler|string|null $twirler): void;
}
