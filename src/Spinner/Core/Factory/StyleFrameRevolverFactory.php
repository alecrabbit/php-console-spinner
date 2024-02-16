<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

final readonly class StyleFrameRevolverFactory implements IStyleFrameRevolverFactory
{
    public function __construct(
        private IFrameCollectionRevolverBuilder $frameRevolverBuilder,
        private IFrameCollectionFactory $frameCollectionFactory,
        private IPatternFactory $patternFactory,
        private IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IPalette $palette): IFrameRevolver
    {
        $pattern = $this->patternFactory->create($palette);

        $frameCollection = $this->frameCollectionFactory->create(
            $pattern->getFrames()
        );

        return $this->frameRevolverBuilder
            ->withFrames($frameCollection)
            ->withInterval($pattern->getInterval())
            ->withTolerance($this->revolverConfig->getTolerance())
            ->build()
        ;
    }
}
