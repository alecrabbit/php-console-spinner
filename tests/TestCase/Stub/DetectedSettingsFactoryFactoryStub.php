<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Stub;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Settings;

class DetectedSettingsFactoryFactoryStub implements IInvokable
{
    public function __invoke(): IDetectedSettingsFactory
    {
        return new class() implements IDetectedSettingsFactory {
            public function create(): ISettings
            {
                return new Settings(); // empty object considered as AUTO
            }
        };
    }

}
