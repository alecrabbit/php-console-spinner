<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Legacy\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
interface ILegacyWidgetConfig
{
    public function getLeadingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): ILegacyWidgetConfig;

    public function getTrailingSpacer(): ?IFrame;

    public function setTrailingSpacer(?IFrame $trailingSpacer): ILegacyWidgetConfig;

    public function getStylePattern(): ?IStyleLegacyPattern;

    public function setStylePattern(?IStyleLegacyPattern $stylePattern): ILegacyWidgetConfig;

    public function getCharPattern(): ?ILegacyPattern;

    public function setCharPattern(?ILegacyPattern $charPattern): ILegacyWidgetConfig;

    /**
     * Merges properties of $this and $other. Properties of $this replaced only if null. Creates a new WidgetConfig
     * instance.
     *
     * @param ILegacyWidgetConfig $other
     * @return ILegacyWidgetConfig
     */
    public function merge(ILegacyWidgetConfig $other): ILegacyWidgetConfig;
}
