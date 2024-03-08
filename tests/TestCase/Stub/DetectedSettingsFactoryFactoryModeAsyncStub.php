<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Stub;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Option\ExecutionOption;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use ArrayObject;

class DetectedSettingsFactoryFactoryModeAsyncStub implements IInvokable
{
    public function __invoke(): IDetectedSettingsFactory
    {
        return new class() implements IDetectedSettingsFactory {
            public function create(): ISettings
            {
                return new Settings(
                    new ArrayObject([
                        new GeneralSettings(
                            executionOption: ExecutionOption::ASYNC,
                        )
                    ])
                );
            }
        };
    }

}
