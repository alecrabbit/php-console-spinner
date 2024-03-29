<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IDriverProvider
{
    public function getDriver(): IDriver;
}
