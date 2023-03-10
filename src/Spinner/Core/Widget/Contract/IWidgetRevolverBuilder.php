<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

interface IWidgetRevolverBuilder extends IRevolverBuilder
{


    public function withStyleRevolver(?IFrameCollectionRevolver $styleRevolver): static;

    public function withCharRevolver(IFrameCollectionRevolver $charRevolver): static;
}
