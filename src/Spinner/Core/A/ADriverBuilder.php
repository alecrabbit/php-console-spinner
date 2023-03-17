<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;

abstract class ADriverBuilder implements IDriverBuilder
{
    public function __construct(
        protected IDefaults $defaults,

    ) {
    }

    /**
     * @inheritDoc
     */
    public function build(): IDriver
    {
        // TODO: Implement build() method.
    }
}