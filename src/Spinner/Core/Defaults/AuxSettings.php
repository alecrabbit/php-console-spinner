<?php

declare(strict_types=1);

// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected OptionNormalizerMode $optionNormalizerMode = OptionNormalizerMode::BALANCED,
        protected OptionCursor $optionCursor = OptionCursor::HIDDEN,
        protected OptionStyleMode $optionStyleMode = OptionStyleMode::ANSI8,
        protected $outputStream = STDERR,
    ) {
    }

    public function getOptionNormalizerMode(): OptionNormalizerMode
    {
        return $this->optionNormalizerMode;
    }

    public function setOptionNormalizerMode(OptionNormalizerMode $optionNormalizerMode): IAuxSettings
    {
        $this->optionNormalizerMode = $optionNormalizerMode;
        return $this;
    }

    public function getOptionCursor(): OptionCursor
    {
        return $this->optionCursor;
    }

    public function setOptionCursor(OptionCursor $optionCursor): IAuxSettings
    {
        $this->optionCursor = $optionCursor;
        return $this;
    }

    public function getOptionStyleMode(): OptionStyleMode
    {
        return $this->optionStyleMode;
    }

    public function setOptionStyleMode(OptionStyleMode $optionStyleMode): IAuxSettings
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
    public function setOutputStream($outputStream): IAuxSettings
    {
        $this->outputStream = $outputStream;
        return $this;
    }
}
