<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IWigglerContainer
{
    public function getWigglers(): iterable;
}
