<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionStyleMode;

interface IAuxSettings
{
    public function getInterval(): IInterval;

    public function setInterval(IInterval $interval): IAuxSettings;

    public function getNormalizerMode(): NormalizerMode;

    public function setNormalizerMode(NormalizerMode $normalizerMode): IAuxSettings;

    public function getCursorOption(): OptionCursor;

    public function setCursorOption(OptionCursor $cursorOption): IAuxSettings;

    public function getOptionStyleMode(): OptionStyleMode;

    public function setOptionStyleMode(OptionStyleMode $optionStyleMode): IAuxSettings;
}
