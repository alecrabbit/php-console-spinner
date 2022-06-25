<?php

declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;

trait ContextAware
{
    protected ITwirlerContext $context;

    public function setContext(ITwirlerContext $context): void
    {
        $this->context = $context;
    }
}
