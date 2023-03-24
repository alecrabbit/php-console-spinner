<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IFrameRenderer
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function render(string $entry): IFrame;

    public function isStyleEnabled(): bool;
}