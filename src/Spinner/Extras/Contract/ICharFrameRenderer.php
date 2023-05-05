<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameRenderer;

interface ICharFrameRenderer extends IFrameRenderer
{
    public function render(string $entry): IFrame;
}
