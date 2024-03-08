<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\OutputConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class OutputConfigBuilder implements IOutputConfigBuilder
{
    private ?StylingMode $stylingMode = null;
    private ?CursorVisibilityMode $cursorVisibilityMode = null;
    private ?InitializationMode $initializationMode = null;
    private mixed $stream = null;

    public function build(): IOutputConfig
    {
        $this->validate();

        return new OutputConfig(
            stylingMode: $this->stylingMode,
            cursorVisibilityMode: $this->cursorVisibilityMode,
            initializationMode: $this->initializationMode,
            stream: $this->stream,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->stylingMode === null => throw new LogicException('StylingMode is not set.'),
            $this->cursorVisibilityMode === null => throw new LogicException('CursorVisibilityMode is not set.'),
            $this->initializationMode === null => throw new LogicException('InitializationMode is not set.'),
            $this->stream === null => throw new LogicException('Stream is not set.'),
            default => null,
        };
    }

    public function withStylingMode(StylingMode $stylingMode): IOutputConfigBuilder
    {
        $clone = clone $this;
        $clone->stylingMode = $stylingMode;
        return $clone;
    }

    public function withCursorVisibilityMode(CursorVisibilityMode $cursorVisibilityMode): IOutputConfigBuilder
    {
        $clone = clone $this;
        $clone->cursorVisibilityMode = $cursorVisibilityMode;
        return $clone;
    }

    public function withInitializationMode(InitializationMode $initializationMode): IOutputConfigBuilder
    {
        $clone = clone $this;
        $clone->initializationMode = $initializationMode;
        return $clone;
    }

    public function withStream(mixed $stream): IOutputConfigBuilder
    {
        $clone = clone $this;
        $clone->stream = $stream;
        return $clone;
    }
}
