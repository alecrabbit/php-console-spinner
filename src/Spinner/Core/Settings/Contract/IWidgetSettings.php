<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\IFrame;

interface IWidgetSettings
{
    public function setTrailingSpacer(?IFrame $trailingSpacer): void;

    public function getLeadingSpacer(): ?IFrame;

    public function getTrailingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): void;
}
