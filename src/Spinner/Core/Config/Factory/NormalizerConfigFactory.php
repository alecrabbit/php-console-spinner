<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\INormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\INormalizerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;

final readonly class NormalizerConfigFactory implements INormalizerConfigFactory, IInvokable
{
    public function __construct(
        protected INormalizerModeSolver $normalizerModeSolver,
        protected INormalizerConfigBuilder $normalizerConfigBuilder,
    ) {
    }

    public function create(): INormalizerConfig
    {
        return $this->normalizerConfigBuilder
            ->withNormalizerMode(
                $this->normalizerModeSolver->solve()
            )
            ->build()
        ;
    }

    public function __invoke(): INormalizerConfig
    {
        return $this->create();
    }
}
