<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\IContext;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface IMultiSpinner extends CanAddTwirler
{
    public function add(ITwirler $twirler): IContext;
}
