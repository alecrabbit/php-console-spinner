<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ISpinnerSetup;
use AlecRabbit\Spinner\Exception\LogicException;

final class SpinnerSetup implements ISpinnerSetup
{
    protected bool $initializationEnabled = false;
    protected bool $attacherEnabled = false;

    public function __construct(
        protected ISpinnerAttacher $attacher,
    ) {
    }

    public function setup(ISpinner $spinner): void
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
