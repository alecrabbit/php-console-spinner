<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface IOutputConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IOutputConfig;

    public function withCursorVisibilityMode(CursorVisibilityMode $cursorVisibilityMode): IOutputConfigBuilder;

    public function withStylingMethodMode(StylingMethodMode $stylingMethodMode): IOutputConfigBuilder;

    public function withInitializationMode(InitializationMode $initializationMode): IOutputConfigBuilder;

    public function withStream(mixed $stream): IOutputConfigBuilder;
}
