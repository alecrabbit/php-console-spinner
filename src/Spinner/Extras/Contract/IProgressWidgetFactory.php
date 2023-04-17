<?php

declare(strict_types=1);

// 24.02.23

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

interface IProgressWidgetFactory
{
    public static function createProgressSteps(
        IProgressValue $progressValue,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite;

    public static function createProcedureWidget(
        IProcedure $procedure,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IRevolver $styleRevolver = null,
    ): IWidgetComposite;
}
