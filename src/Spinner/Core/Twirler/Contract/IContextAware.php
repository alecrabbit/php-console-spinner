<?php
declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

interface IContextAware
{
    public function setContext(IContext $context): void;
}
