<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{
    public function withStyleRevolver(IRevolver $styleRevolver): static;

    public function withCharRevolver(IRevolver $charRevolver): static;
}
