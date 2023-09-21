<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{
    public function build(): IWidgetRevolver;

    public function withCharRevolver(IRevolver $charRevolver): IWidgetRevolverBuilder;

    public function withStyleRevolver(IRevolver $styleRevolver): IWidgetRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): IWidgetRevolverBuilder;
}
