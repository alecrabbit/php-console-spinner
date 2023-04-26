<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerSetup;

final class LegacySpinnerSetup implements ILegacySpinnerSetup
{
    protected bool $initializationEnabled = false;
    protected bool $attacherEnabled = false;

    public function __construct(
        protected ILegacySpinnerAttacher $attacher,
    ) {
    }

    public function setup(ILegacySpinner $spinner): void
    {
        if ($this->initializationEnabled) {
            $spinner->initialize();
        }

        if ($this->attacherEnabled) {
            $this->attacher->attach($spinner);
        }
    }

    public function enableInitialization(bool $enable): ILegacySpinnerSetup
    {
        $this->initializationEnabled = $enable;
        return $this;
    }

    public function enableAttacher(bool $enable): ILegacySpinnerSetup
    {
        $this->attacherEnabled = $enable;
        return $this;
    }
}
