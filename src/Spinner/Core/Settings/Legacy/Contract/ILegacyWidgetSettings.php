<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
interface ILegacyWidgetSettings
{
    public function getLeadingSpacer(): IFrame;

    public function setLeadingSpacer(IFrame $frame): ILegacyWidgetSettings;

    public function getTrailingSpacer(): IFrame;

    public function setTrailingSpacer(IFrame $frame): ILegacyWidgetSettings;

    public function getStylePattern(): IStyleLegacyPattern;

    public function setStylePattern(IStyleLegacyPattern $pattern): ILegacyWidgetSettings;

    public function getCharPattern(): ILegacyPattern;

    public function setCharPattern(ILegacyPattern $pattern): ILegacyWidgetSettings;
}
