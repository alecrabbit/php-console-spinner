<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{
    public function withStylePattern(IPattern $stylePattern): IWidgetRevolverBuilder;

    public function withCharPattern(IPattern $charPattern): IWidgetRevolverBuilder;
}
