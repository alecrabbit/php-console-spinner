<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Stub;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;

class DetectedSettingsFactoryFactoryModeAsyncStub implements IInvokable
{
    public function __invoke(): IDetectedSettingsFactory
    {
        return new class() implements IDetectedSettingsFactory {
            public function create(): ISettings
            {
                return new Settings(
                    new \ArrayObject([
                        new GeneralSettings(
                            runMethodOption: ExecutionModeOption::ASYNC,
                        )
                    ])
                );
            }
        };
    }

}
