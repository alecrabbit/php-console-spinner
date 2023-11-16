<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;

interface INormalizerSettings extends ISettingsElement
{
    public function getNormalizerOption(): NormalizerOption;
}
