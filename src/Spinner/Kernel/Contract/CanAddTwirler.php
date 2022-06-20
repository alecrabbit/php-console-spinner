<?php
declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

interface CanAddTwirler
{
    public function addTwirler(ITwirler $twirler): CanAddTwirler;
}
