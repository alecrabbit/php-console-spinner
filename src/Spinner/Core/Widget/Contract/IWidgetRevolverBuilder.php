<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{
    public function withCharRevolver(IRevolver $charRevolver): IWidgetRevolverBuilder;

    public function withStyleRevolver(IRevolver $styleRevolver): IWidgetRevolverBuilder;
}
