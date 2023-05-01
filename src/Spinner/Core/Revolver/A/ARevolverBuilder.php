<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

abstract class ARevolverBuilder
{
    abstract public function build(): IRevolver;
}
