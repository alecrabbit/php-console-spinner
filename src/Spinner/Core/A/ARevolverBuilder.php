<?php

declare(strict_types=1);

// 20.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

abstract class ARevolverBuilder
{
    abstract public function build(): IRevolver;
}
