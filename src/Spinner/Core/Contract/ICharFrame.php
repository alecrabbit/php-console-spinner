<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ICharFrame
{
    public static function createEmpty(): ICharFrame;

    public static function createSpace(): ICharFrame;
}
