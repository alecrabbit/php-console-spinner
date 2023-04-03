<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected IInterval $interval,
        protected NormalizerMode $normalizerMode,
        protected OptionCursor $cursorOption,
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

    public function getNormalizerMode(): NormalizerMode
    {
        return $this->normalizerMode;
    }

    public function setNormalizerMode(NormalizerMode $normalizerMode): IAuxSettings
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
}
