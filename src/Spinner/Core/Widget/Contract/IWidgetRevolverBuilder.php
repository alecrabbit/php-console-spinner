<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{
    public function withStyleRevolver(IRevolver $styleRevolver): static;

    public function withCharRevolver(IRevolver $charRevolver): static;

    public function withStylePattern(IPattern $stylePattern): static;

    public function withCharPattern(IPattern $charPattern): static;
}
