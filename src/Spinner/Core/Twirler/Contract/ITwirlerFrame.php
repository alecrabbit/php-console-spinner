<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;

interface ITwirlerFrame
{
    public function getStyleFrame(): IStyleFrame;

    public function getCharFrame(): ICharFrame;
}
