<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\CharPattern;

final readonly class CharPatternFactory implements ICharPatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private ICharFrameTransformer $transformer,
    ) {
    }

    public function create(IPalette $palette): ICharPattern
    {
//        if ($palette instanceof IPalette) {
//            // FIXME (2024-02-20 16:31) [Alec Rabbit]:STUB! [343d6cb2-4ca9-41de-9436-2b10154e6c95] Remove this
//            $palette = new NoCharPalette(
//                options: new PaletteOptions(
//                    interval: 100,
//                ),
//                frame: new CharSequenceFrame('-', 1),
//            );
//        }

        return new CharPattern(
            frames: $palette,
            interval: $this->createInterval($palette->getOptions()->getInterval()),
            transformer: $this->transformer,
        );
    }

    private function createInterval(?int $interval): IInterval
    {
        return $this->intervalFactory->createNormalized($interval);
    }


}
