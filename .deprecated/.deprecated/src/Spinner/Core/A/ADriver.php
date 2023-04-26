<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\DTO\DriverSettingsDTO;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

abstract class ADriver
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    protected IFrame $currentFrame;
    protected int $previousFrameWidth = 0;

    public function __construct(
        protected readonly IBufferedOutput $output,
        protected readonly ICursor $cursor,
        protected readonly ITimer $timer,
        protected readonly DriverSettingsDTO $driverSettings,
    ) {
    }

}
