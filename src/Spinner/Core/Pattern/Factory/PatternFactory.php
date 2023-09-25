<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Template;

final class PatternFactory implements IPatternFactory
{
    public function create(IPalette $palette): ITemplate
    {
        $entries = $palette->getEntries();

        return
            new Template();
    }
}
