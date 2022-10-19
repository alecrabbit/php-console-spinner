<?php
declare(strict_types=1);
// 19.10.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ACharFrame;

interface IWidget
{
    public function render(): IWidgetFrame;

}
