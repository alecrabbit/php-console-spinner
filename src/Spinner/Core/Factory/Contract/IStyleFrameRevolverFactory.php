<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface IStyleFrameRevolverFactory
{
    public function createStyleRevolver(IStyleLegacyPattern $stylePattern): IFrameRevolver;

    public function create(ITemplate $template): IFrameRevolver;
}
