<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ISpinnerSetup
{

    public function setup(ILegacySpinner $spinner): void;

    public function enableInitialization(bool $enable): ISpinnerSetup;

    public function enableAttacher(bool $enable): ISpinnerSetup;

}
