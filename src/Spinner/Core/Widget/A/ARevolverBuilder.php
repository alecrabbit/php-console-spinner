<?php
declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

abstract class ARevolverBuilder implements IRevolverBuilder
{
    public function __construct(
        protected IDefaults $defaults,
    ) {
    }
}