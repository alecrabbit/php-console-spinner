<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\IMultiSpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\IContext;
use AlecRabbit\Spinner\Core\Twirler\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

final class MultiSpinner extends ABaseSpinner implements IMultiSpinner
{
    public function add(ITwirler $twirler): IContext
    {
        return
            $this->container->add($twirler);
    }
}
