<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;

interface IAuxConfig
{
    public function getInterval(): IInterval;

    public function getNormalizerMode(): OptionNormalizerMode;

    public function getCursorOption(): OptionCursor;

    public function getStyleModeOption(): OptionStyleMode;

    /**
     * @return resource
     */
    public function getOutputStream();
}
