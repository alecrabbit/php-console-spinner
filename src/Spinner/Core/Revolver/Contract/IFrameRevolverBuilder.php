<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IFrameRevolverBuilder extends IRevolverBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IFrameRevolver;

    public function withPattern(IPattern $pattern): static;
}
