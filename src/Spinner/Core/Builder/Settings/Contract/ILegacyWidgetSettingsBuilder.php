<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;

interface ILegacyWidgetSettingsBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): ILegacyWidgetSettings;

    public function withTrailingSpacer(IFrame $frame): ILegacyWidgetSettingsBuilder;

    public function withLeadingSpacer(IFrame $frame): ILegacyWidgetSettingsBuilder;

    public function withStylePattern(IStylePattern $pattern): ILegacyWidgetSettingsBuilder;

    public function withCharPattern(IPattern $pattern): ILegacyWidgetSettingsBuilder;
}
