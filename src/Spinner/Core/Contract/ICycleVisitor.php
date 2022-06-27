<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface ICycleVisitor
{
    public function visit(IIntervalComponent $container): void;
}
