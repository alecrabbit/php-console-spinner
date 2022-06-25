<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface IMultiSpinner
{
    public function add(ITwirler $twirler): ITwirlerContext;
}
