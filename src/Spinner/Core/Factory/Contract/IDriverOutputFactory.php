<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

interface IDriverOutputFactory
{
    public function create(): IDriverOutput;
}
