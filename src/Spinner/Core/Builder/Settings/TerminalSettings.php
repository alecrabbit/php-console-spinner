<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;

final class TerminalSettings implements ITerminalSettings
{
    public function __construct(
        protected OptionCursor $optionCursor,
        protected OptionStyleMode $optionStyleMode,
        protected $outputStream,
    ) {
    }

    public function getOptionCursor(): OptionCursor
    {
        return $this->optionCursor;
    }

    public function setOptionCursor(OptionCursor $optionCursor): ITerminalSettings
    {
        $this->optionCursor = $optionCursor;
        return $this;
    }

    public function getOptionStyleMode(): OptionStyleMode
    {
        return $this->optionStyleMode;
    }

    public function setOptionStyleMode(OptionStyleMode $optionStyleMode): ITerminalSettings
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
