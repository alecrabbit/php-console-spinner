<?php
declare(strict_types=1);
// 11.03.23
namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use AlecRabbit\Spinner\Mixin\PrivateConstructorTrait;

abstract class AClass
{
    protected mixed $value = null;

//    use NoInstanceTrait;
    use PrivateConstructorTrait;

}