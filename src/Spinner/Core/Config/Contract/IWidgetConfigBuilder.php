<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IWidgetConfigBuilder
{
    public function build(): IWidgetConfig;

    public function withStyleRevolver(IRevolver $revolver): static;

    public function withCharRevolver(IRevolver $revolver): static;

    public function withStylePattern(IPattern $pattern): static;

    public function withCharPattern(IPattern $pattern): static;

    public function withLeadingSpacer(IFrame $frame): static;

    public function withTrailingSpacer(IFrame $frame): static;
}
