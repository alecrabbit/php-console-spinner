<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface ICharFrameRevolverFactory
{
    public function createCharRevolver(IPattern $charPattern): IFrameRevolver;

    public function create(ITemplate $template): IFrameRevolver;
}
