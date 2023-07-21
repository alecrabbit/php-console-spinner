<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetSettingsBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): ILegacyWidgetSettings;

    public function withTrailingSpacer(IFrame $frame): IWidgetSettingsBuilder;

    public function withLeadingSpacer(IFrame $frame): IWidgetSettingsBuilder;

    public function withStylePattern(IStylePattern $pattern): IWidgetSettingsBuilder;

    public function withCharPattern(IPattern $pattern): IWidgetSettingsBuilder;
}
