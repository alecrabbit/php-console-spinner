<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Exception\DomainException;

interface IFacade
{

    public static function getDriver(): IDriver;

    /**
     * @throws DomainException
     */
    public static function getSettings(): ISettings;

    public static function getLoop(): ILoop;

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): ISpinner;
}
