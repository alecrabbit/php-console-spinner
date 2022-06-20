<?php
declare(strict_types=1);
// 18.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;

interface Renderable
{
    public function render(): ICharFrame;
}
