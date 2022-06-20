<?php
declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;

interface IStyleRevolverFactory
{
    public function create(?IStyleFrameCollection $styleCollection = null): IStyleRevolver;
}
