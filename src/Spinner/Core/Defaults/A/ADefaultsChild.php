<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsChild;

abstract class ADefaultsChild implements IDefaultsChild
{
    public function __construct(
        protected IDefaults $parent,
    ) {
    }

    public function toParent(): IDefaults
    {
        return $this->parent;
    }
}