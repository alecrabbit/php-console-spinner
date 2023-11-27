<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class RevolverConfigBuilder implements IRevolverConfigBuilder
{
    private ?ITolerance $tolerance = null;

    public function build(): IRevolverConfig
    {
        $this->validate();

        return new RevolverConfig(
            tolerance: $this->tolerance,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->tolerance === null => throw new LogicException('Tolerance is not set.'),
            default => null,
        };
    }

    public function withTolerance(ITolerance $tolerance): IRevolverConfigBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
