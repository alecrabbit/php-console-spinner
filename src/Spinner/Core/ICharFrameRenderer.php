<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameRenderer;

interface ICharFrameRenderer extends IFrameRenderer
{
    public function render(string $entry): IFrame;
}
