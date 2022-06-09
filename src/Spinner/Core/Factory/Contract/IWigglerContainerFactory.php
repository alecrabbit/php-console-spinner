<?php
declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;

interface IWigglerContainerFactory
{
    public static function create(IFrameContainer $frames): IWigglerContainer;
}
