<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILegacySpinnerSetup
{

    public function setup(ILegacySpinner $spinner): void;

    public function enableInitialization(bool $enable): ILegacySpinnerSetup;

    public function enableAttacher(bool $enable): ILegacySpinnerSetup;

}
