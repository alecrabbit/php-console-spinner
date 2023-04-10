<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Helper\Asserter;

final class AuxConfig implements IAuxConfig
{
    public function __construct(
        protected IInterval $interval,
        protected OptionNormalizerMode $normalizerMode,
        protected OptionCursor $cursorOption,
        protected OptionStyleMode $optionStyleMode,
        protected $outputStream,
    ) {
        Asserter::assertStream($outputStream);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getNormalizerMode(): OptionNormalizerMode
    {
        return $this->normalizerMode;
    }

    public function getCursorOption(): OptionCursor
    {
        return $this->cursorOption;
    }

    public function getStyleModeOption(): OptionStyleMode
    {
        return $this->optionStyleMode;
    }

    public function getOutputStream()
    {
        return $this->outputStream;
    }
}
