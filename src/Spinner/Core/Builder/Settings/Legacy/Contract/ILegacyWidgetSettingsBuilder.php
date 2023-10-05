<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @deprecated Will be removed
 */
interface ILegacyWidgetSettingsBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): ILegacyWidgetSettings;

    public function withTrailingSpacer(IFrame $frame): ILegacyWidgetSettingsBuilder;

    public function withLeadingSpacer(IFrame $frame): ILegacyWidgetSettingsBuilder;

    public function withStylePattern(IStyleLegacyPattern $pattern): ILegacyWidgetSettingsBuilder;

    public function withCharPattern(ILegacyPattern $pattern): ILegacyWidgetSettingsBuilder;
}
