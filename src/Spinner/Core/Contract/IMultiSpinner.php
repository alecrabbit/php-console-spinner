<?php
declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface IMultiSpinner extends IBaseSpinner
{
    public function addTwirler(ITwirler $twirler): void;
}
