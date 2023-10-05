<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;

interface ISpinnerFactory
{
    /**
     * @deprecated
     */
    public function legacyCreateSpinner(ILegacySpinnerConfig|ILegacyWidgetConfig|null $config = null): ISpinner;

    public function create(?ISpinnerSettings $spinnerSettings = null): ISpinner;
}
