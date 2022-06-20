<?php
declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Factory\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;

interface ICharRevolverFactory
{
    public function create(): ICharRevolver;
}
