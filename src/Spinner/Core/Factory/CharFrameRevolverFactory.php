<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

final class CharFrameRevolverFactory implements ICharFrameRevolverFactory
{
    public function __construct(
        protected IFrameCollectionRevolverBuilder $frameRevolverBuilder,
        protected IFrameCollectionFactory $frameCollectionFactory,
        protected IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IPattern $pattern): IFrameRevolver
    {
        return $this->frameRevolverBuilder
            ->withFrames(
                $this->frameCollectionFactory
                    ->create(
                        $pattern->getFrames()
                    )
            )
            ->withInterval(
                $pattern->getInterval()
            )
            ->withTolerance(
                $this->revolverConfig->getTolerance()
            )
            ->build()
        ;
    }
}
