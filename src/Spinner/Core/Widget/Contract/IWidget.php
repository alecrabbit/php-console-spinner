<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\ISubject;

interface IWidget extends ISubject,
                          IHasInterval,
                          IHasSequenceFrame
{
}
