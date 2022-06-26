<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\IMultiSpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

final class MultiSpinner extends ABaseSpinner implements IMultiSpinner
{
    public function add(ITwirler $twirler): ITwirlerContext
    {
        $context = $this->container->add($twirler);
        $this->acceptIntervalVisitor();
        $this->acceptCycleVisitor();
        return
            $context;
    }

    public function remove(ITwirlerContext|ITwirler $element): void
    {
        $this->container->remove($element);
        $this->acceptIntervalVisitor();
        $this->acceptCycleVisitor();
    }
}
