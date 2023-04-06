<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionStyleMode;

interface IAuxConfig
{
    public function getInterval(): IInterval;

    public function getNormalizerMode(): NormalizerMode;

    public function getCursorOption(): OptionCursor;

    public function getStyleModeOption(): OptionStyleMode;

    /**
     * @return resource
     */
    public function getOutputStream();
}
