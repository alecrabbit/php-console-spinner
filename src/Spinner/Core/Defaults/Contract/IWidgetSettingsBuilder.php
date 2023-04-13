<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetSettingsBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetSettings;

    public function withTrailingSpacer(IFrame $frame): IWidgetSettingsBuilder;

    public function withLeadingSpacer(IFrame $frame): IWidgetSettingsBuilder;

    public function withStylePattern(IPattern $pattern): IWidgetSettingsBuilder;

    public function withCharPattern(IPattern $pattern): IWidgetSettingsBuilder;

}
