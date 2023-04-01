<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use ArrayObject;

final class RevolverFactory implements IRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected IFrameFactory $frameFactory,
        protected IIntervalFactory $intervalFactory,
    )
    {
    }

    public function defaultStyleRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        $this->frameFactory->create('%s', 0),
                    ])
                ),
                $this->intervalFactory->createStill()
            );
    }

    public function create(IPattern $pattern): IRevolver
    {
        return $this->frameRevolverBuilder->withPattern($pattern)->build();
    }


    public function defaultCharRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        $this->frameFactory::createEmpty(),
                    ])
                ),
                $this->intervalFactory->createStill()
            );
    }
}
