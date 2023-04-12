<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;

interface IDriverSettings
{
    /**
     * @deprecated
     */
    public function getFinalMessage(): string;

    /**
     * @deprecated
     */
    public function getInterruptMessage(): string;

    public function isInitializationEnabled(): bool;

    public function isAttacherEnabled(): bool;

    public function setOptionInitialization(OptionInitialization $optionInitialization): IDriverSettings;

    public function setOptionAttacher(OptionAttacher $optionAttacher): IDriverSettings;

    public function getOptionAttacher(): OptionAttacher;
}
