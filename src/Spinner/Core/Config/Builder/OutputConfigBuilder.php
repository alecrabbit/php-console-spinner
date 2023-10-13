<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\OutputConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class OutputConfigBuilder implements IOutputConfigBuilder
{
    private ?StylingMethodMode $stylingMethodMode = null;
    private ?CursorVisibilityMode $cursorVisibilityMode = null;

    /**
     * @inheritDoc
     */
    public function build(): IOutputConfig
    {
        $this->validate();

        return
            new OutputConfig(
                stylingMethodMode: $this->stylingMethodMode,
                cursorVisibilityMode: $this->cursorVisibilityMode,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->stylingMethodMode === null => throw new LogicException('StylingMethodMode is not set.'),
            $this->cursorVisibilityMode === null => throw new LogicException('CursorVisibilityMode is not set.'),
            default => null,
        };
    }

    public function withStylingMethodMode(StylingMethodMode $stylingMethodMode): IOutputConfigBuilder
    {
        $clone = clone $this;
        $clone->stylingMethodMode = $stylingMethodMode;
        return $clone;
    }

    public function withCursorVisibilityMode(CursorVisibilityMode $cursorVisibilityMode): IOutputConfigBuilder
    {
        $clone = clone $this;
        $clone->cursorVisibilityMode = $cursorVisibilityMode;
        return $clone;
    }
}
