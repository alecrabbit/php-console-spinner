<?php
declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Twirler\Contract\IContext;

trait ContextAware
{
    protected IContext $context;

    public function setContext(IContext $context): void
    {
        $this->context = $context;
    }
}
