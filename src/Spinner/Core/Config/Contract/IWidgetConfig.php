<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

interface IWidgetConfig
{
    public function getLeadingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): IWidgetConfig;

    public function getTrailingSpacer(): ?IFrame;

    public function setTrailingSpacer(?IFrame $trailingSpacer): IWidgetConfig;

    public function getStylePattern(): ?IStylePattern;

    public function setStylePattern(?IStylePattern $stylePattern): IWidgetConfig;

    public function getCharPattern(): ?IPattern;

    public function setCharPattern(?IPattern $charPattern): IWidgetConfig;

    /**
     * Merges properties of $this and $other. Properties of $this replaced only if null. Creates a new WidgetConfig
     * instance.
     *
     * @param IWidgetConfig $other
     * @return IWidgetConfig
     */
    public function merge(IWidgetConfig $other): IWidgetConfig;
}
