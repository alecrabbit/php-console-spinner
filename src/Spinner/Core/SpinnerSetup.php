<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ISpinnerSetup;

final class SpinnerSetup implements ISpinnerSetup
{
    protected bool $initializationEnabled = false;
    protected bool $attacherEnabled = false;

    public function __construct(
        protected ISpinnerAttacher $attacher,
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

    public function enableInitialization(bool $enable): ISpinnerSetup
    {
        $this->initializationEnabled = $enable;
        return $this;
    }

    public function enableAttacher(bool $enable): ISpinnerSetup
    {
        $this->attacherEnabled = $enable;
        return $this;
    }
}
