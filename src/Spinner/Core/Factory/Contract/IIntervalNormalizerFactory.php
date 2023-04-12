<?php

declare(strict_types=1);
// 11.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

interface IIntervalNormalizerFactory
{
    public function create(): IIntervalNormalizer;
}
