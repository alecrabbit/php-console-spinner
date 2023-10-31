<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;

final readonly class OutputConfig implements IOutputConfig
{
    public function __construct(
        protected StylingMethodMode $stylingMethodMode,
        protected CursorVisibilityMode $cursorVisibilityMode,
        protected InitializationMode $initializationMode,
        protected mixed $stream,
    ) {
    }

    public function getStylingMethodMode(): StylingMethodMode
    {
        return $this->stylingMethodMode;
    }

    public function getCursorVisibilityMode(): CursorVisibilityMode
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
