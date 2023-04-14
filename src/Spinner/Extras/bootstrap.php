<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart

Facade::useService(
    IHexColorToAnsiCodeConverter::class,
    HexColorToAnsiCodeConverter::class,
);

// @codeCoverageIgnoreEnd
