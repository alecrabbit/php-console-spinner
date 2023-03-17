<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;

interface IWidgetSettings extends IDefaultsChild
{
    public static function getInstance(IDefaults $parent): IWidgetSettings;

    public function getLeadingSpacer(): IFrame;

    public function getTrailingSpacer(): IFrame;

    public function setLeadingSpacer(IFrame $frame): static;

    public function setTrailingSpacer(IFrame $frame): static;

    public function getStylePattern(): ?IPattern;

    public function getCharPattern(): ?IPattern;

    public function setStylePattern(IPattern $pattern): static;

    public function setCharPattern(IPattern $pattern): static;
}
