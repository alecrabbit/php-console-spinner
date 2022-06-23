<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IContainer;

interface ITwirlerContainerFactory
{
    public function createContainer(): IContainer;
}
