<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart

Facade::useService(
    IHexColorToAnsiCodeConverterFactory::class,
    HexColorToAnsiCodeConverterFactory::class,
);

// @codeCoverageIgnoreEnd
