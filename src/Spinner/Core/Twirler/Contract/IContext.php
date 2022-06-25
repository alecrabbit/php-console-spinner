<?php
declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

interface IContext extends Renderable
{
    public function render(): ITwirlerFrame;

    public function setTwirler(ITwirler $twirler): void;
}
