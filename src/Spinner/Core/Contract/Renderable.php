<?php
declare(strict_types=1);
// 18.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface Renderable
{
    public function render(): ICharFrame;
}
