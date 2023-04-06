<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Helper\Asserter;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected IInterval $interval,
        protected OptionNormalizerMode $normalizerMode = OptionNormalizerMode::BALANCED,
        protected OptionCursor $cursorOption = OptionCursor::HIDDEN,
        protected OptionStyleMode $optionStyleMode = OptionStyleMode::ANSI8,
        protected $outputStream = STDERR,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function setInterval(IInterval $interval): IAuxSettings
    {
        $this->interval = $interval;
        return $this;
    }

    public function getNormalizerMode(): OptionNormalizerMode
    {
        return $this->normalizerMode;
    }

    public function setNormalizerMode(OptionNormalizerMode $normalizerMode): IAuxSettings
    {
        $this->normalizerMode = $normalizerMode;
        return $this;
    }

    public function getCursorOption(): OptionCursor
    {
        return $this->cursorOption;
    }

    public function setCursorOption(OptionCursor $cursorOption): IAuxSettings
    {
        $this->cursorOption = $cursorOption;
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
        Asserter::assertStream($outputStream);
        $this->outputStream = $outputStream;
        return $this;
    }
}
