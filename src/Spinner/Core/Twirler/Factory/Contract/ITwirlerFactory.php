<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface ITwirlerFactory
{
    public function spinner(): ITwirler;

    public function message(string|null $value): ITwirler;

    public function progress(string|float|null $value): ITwirler;
}
