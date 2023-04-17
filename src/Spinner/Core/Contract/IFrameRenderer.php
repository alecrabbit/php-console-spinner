<?php

declare(strict_types=1);

// 04.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;

interface IFrameRenderer
{
    public function emptyFrame(): IFrame;
}
