<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;

interface IAuxSettings extends ISettingsElement
{
    public function setRunMethodOption(RunMethodOption $runMethodOption): void;

    public function setNormalizerOption(NormalizerOption $normalizerOption): void;

    public function getNormalizerOption(): NormalizerOption;

    public function getRunMethodOption(): RunMethodOption;
}
