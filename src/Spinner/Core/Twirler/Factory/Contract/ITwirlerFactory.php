<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IMessage;
use AlecRabbit\Spinner\Core\Contract\IProgress;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface ITwirlerFactory
{
    public function spinner(): ITwirler;

    public function message(IMessage $message): ITwirler;

    public function progress(IProgress $progress): ITwirler;
}
