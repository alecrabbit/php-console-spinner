<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface INormalizerConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): INormalizerConfig;

    public function withNormalizerMode(NormalizerMode $normalizerMode): INormalizerConfigBuilder;
}
