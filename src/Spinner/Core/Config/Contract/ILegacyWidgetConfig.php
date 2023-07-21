<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

interface ILegacyWidgetConfig
{
    public function getLeadingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): ILegacyWidgetConfig;

    public function getTrailingSpacer(): ?IFrame;

    public function setTrailingSpacer(?IFrame $trailingSpacer): ILegacyWidgetConfig;

    public function getStylePattern(): ?IStylePattern;

    public function setStylePattern(?IStylePattern $stylePattern): ILegacyWidgetConfig;

    public function getCharPattern(): ?IPattern;

    public function setCharPattern(?IPattern $charPattern): ILegacyWidgetConfig;

    /**
     * Merges properties of $this and $other. Properties of $this replaced only if null. Creates a new WidgetConfig
     * instance.
     *
     * @param ILegacyWidgetConfig $other
     * @return ILegacyWidgetConfig
     */
    public function merge(ILegacyWidgetConfig $other): ILegacyWidgetConfig;
}
