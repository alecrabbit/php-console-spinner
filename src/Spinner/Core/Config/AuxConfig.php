<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;

final class AuxConfig implements IAuxConfig
{
    public function __construct(
        protected IInterval $interval,
        protected NormalizerMode $normalizerMode,
        protected OptionCursor $cursorOption,
        protected OptionStyleMode $optionStyleMode,
        protected $outputStream,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getNormalizerMode(): NormalizerMode
    {
        return $this->normalizerMode;
    }

    public function getCursorOption(): OptionCursor
    {
        return $this->cursorOption;
    }

    public function getOptionStyleMode(): OptionStyleMode
    {
        return $this->optionStyleMode;
    }

    public function getOutputStream()
    {
        return $this->outputStream;
    }
}