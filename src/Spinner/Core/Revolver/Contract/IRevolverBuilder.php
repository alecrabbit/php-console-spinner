<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

interface IRevolverBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgument
     */
    public function build(): IRevolver;
}
