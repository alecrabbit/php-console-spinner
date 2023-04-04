<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
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

    public function withFrameCollection(IFrameCollection $frames): static;

    public function withInterval(IInterval $interval): static;

    public function defaultCharRevolver(): IRevolver;

    public function defaultStyleRevolver(): IRevolver;
}
