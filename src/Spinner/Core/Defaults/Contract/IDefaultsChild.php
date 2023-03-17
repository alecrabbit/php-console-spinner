<?php

declare(strict_types=1);
// 16.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface IDefaultsChild
{
    public function toParent(): IDefaults;
}
