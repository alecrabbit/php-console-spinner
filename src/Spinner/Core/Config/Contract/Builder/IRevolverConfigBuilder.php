<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;

interface IRevolverConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IRevolverConfig;

    public function withStylePalette(IPalette $pattern): IRevolverConfigBuilder;

    public function withCharPalette(IPalette $pattern): IRevolverConfigBuilder;
}
