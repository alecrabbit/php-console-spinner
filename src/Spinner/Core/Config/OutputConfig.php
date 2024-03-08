<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;

final readonly class OutputConfig implements IOutputConfig
{
    public function __construct(
        private StylingMode $stylingMode,
        private CursorMode $cursorVisibilityMode,
        private InitializationMode $initializationMode,
        private mixed $stream,
    ) {
    }

    public function getStylingMode(): StylingMode
    {
        return $this->stylingMode;
    }

    public function getCursorMode(): CursorMode
    {
        return $this->cursorVisibilityMode;
    }

    public function getInitializationMode(): InitializationMode
    {
        return $this->initializationMode;
    }

    public function getStream(): mixed
    {
        return $this->stream;
    }

    /**
     * @return class-string<IOutputConfig>
     */
    public function getIdentifier(): string
    {
        return IOutputConfig::class;
    }
}
