<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;

/**
 * @deprecated Will be removed
 */
final class LegacyTerminalSettings implements ILegacyTerminalSettings
{
    public function __construct(
        protected CursorVisibilityOption $optionCursor,
        protected StylingMethodOption $optionStyleMode,
        protected $outputStream,
    ) {
    }

    public function getOptionCursor(): CursorVisibilityOption
    {
        return $this->optionCursor;
    }

    public function setOptionCursor(CursorVisibilityOption $optionCursor): ILegacyTerminalSettings
    {
        $this->optionCursor = $optionCursor;
        return $this;
    }

    public function getOptionStyleMode(): StylingMethodOption
    {
        return $this->optionStyleMode;
    }

    public function setOptionStyleMode(StylingMethodOption $optionStyleMode): ILegacyTerminalSettings
    {
        $this->optionStyleMode = $optionStyleMode;
        return $this;
    }

    /** @inheritDoc */
    public function getOutputStream()
    {
        return $this->outputStream;
    }

    /** @inheritDoc */
    public function setOutputStream($outputStream): ILegacyTerminalSettings
    {
        $this->outputStream = $outputStream;
        return $this;
    }
}
