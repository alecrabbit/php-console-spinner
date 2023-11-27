<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;

interface INormalizerConfigFactory
{
    public function create(): INormalizerConfig;
}
