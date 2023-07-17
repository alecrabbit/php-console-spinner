<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ITerminalSettings;

final class TerminalSettings implements ITerminalSettings
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

    public function setOptionCursor(CursorVisibilityOption $optionCursor): ITerminalSettings
    {
        $this->optionCursor = $optionCursor;
        return $this;
    }

    public function getOptionStyleMode(): StylingMethodOption
    {
        return $this->optionStyleMode;
    }

    public function setOptionStyleMode(StylingMethodOption $optionStyleMode): ITerminalSettings
    {
        $this->optionStyleMode = $optionStyleMode;
        return $this;
    }

    /** @inheritdoc */
    public function getOutputStream()
    {
        return $this->outputStream;
    }

    /** @inheritdoc */
    public function setOutputStream($outputStream): ITerminalSettings
    {
        $this->outputStream = $outputStream;
        return $this;
    }
}
