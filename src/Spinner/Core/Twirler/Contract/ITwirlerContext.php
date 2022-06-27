<?php

declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

interface ITwirlerContext extends Renderable
{
    public function getTwirler(): ITwirler;

    public function render(): ITwirlerFrame;

    public function setTwirler(ITwirler $twirler): void;
}
