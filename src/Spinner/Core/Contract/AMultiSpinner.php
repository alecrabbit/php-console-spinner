<?php

declare(strict_types=1);
// 15.07.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;

abstract class AMultiSpinner extends ASpinner implements IMultiSpinner
{
    public function add(ITwirler $twirler): ITwirlerContext
    {
        $context = $this->container->add($twirler);
        $this->recalculate();
        return
            $context;
    }

    public function remove(ITwirlerContext|ITwirler $element): void
    {
        $this->container->remove($element);
        $this->recalculate();
    }
}
