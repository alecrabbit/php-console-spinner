<?php
declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Contract;

interface ISpinner extends HasInterval
{
    public function update(?float $dt = null): IFrame;
}
