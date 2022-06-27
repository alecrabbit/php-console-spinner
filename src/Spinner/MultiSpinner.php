<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\IMultiSpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;

final class MultiSpinner extends ABaseSpinner implements IMultiSpinner
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
