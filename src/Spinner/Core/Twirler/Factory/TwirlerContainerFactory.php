<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContainer;
use AlecRabbit\Spinner\Core\Twirler\TwirlerContainer;

final class TwirlerContainerFactory implements Contract\ITwirlerContainerFactory
{
    public function __construct()
    {
    }

    public function createContainer(): ITwirlerContainer
    {
        return new TwirlerContainer();
    }
}
