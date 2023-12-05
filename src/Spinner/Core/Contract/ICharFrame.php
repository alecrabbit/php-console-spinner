<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFrame;

interface ICharFrame extends IFrame
{
    /**
     * @deprecated
     */
    public static function createEmpty(): ICharFrame;

    /**
     * @deprecated
     */
    public static function createSpace(): ICharFrame;
}
