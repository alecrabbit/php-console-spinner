<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Pattern;

final class PatternFactory implements IPatternFactory
{
    public function __construct(
        protected IIntervalFactory $intervalFactory,
        protected IPaletteModeFactory $paletteModeFactory,
    ) {
    }

    public function create(IPalette $palette): IPattern
    {
        $mode = $this->paletteModeFactory->create();

        $template = $palette->getTemplate($mode);

        $interval =
            $this->intervalFactory->createNormalized(
                $template->getOptions()->getInterval()
            );

        return
            new Pattern(
                interval: $interval,
                frames: $template->getEntries(),
            );
    }
}
