<?php
declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

interface ITwirler extends Renderable
{
    public function render(): ITwirlerFrame;
}
