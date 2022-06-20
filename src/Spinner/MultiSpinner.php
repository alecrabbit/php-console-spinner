<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\IMultiSpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Exception\MethodNotImplementedException;

final class MultiSpinner extends ABaseSpinner implements IMultiSpinner
{
    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        // FIXME (2022-06-19 19:40) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }
}
