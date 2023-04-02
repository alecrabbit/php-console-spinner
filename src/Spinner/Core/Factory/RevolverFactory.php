<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use ArrayObject;

final class RevolverFactory implements IRevolverFactory
{
    public function __construct(
        protected IFrameRevolverBuilder $frameRevolverBuilder,
        protected IFrameFactory $frameFactory,
    ) {
    }

    public function defaultStyleRevolver(): IRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrameCollection(
                    new FrameCollection(
                        new ArrayObject([
                            $this->frameFactory->create('%s', 0),
                        ])
                    )
                )
                ->build();
    }

    public function create(IPattern $pattern): IRevolver
    {
        return $this->frameRevolverBuilder->withPattern($pattern)->build();
    }


    public function defaultCharRevolver(): IRevolver
    {
        return
            $this->frameRevolverBuilder
                ->withFrameCollection(
                    new FrameCollection(
                        new ArrayObject([
                            $this->frameFactory::createEmpty(),
                        ])
                    )
                )
                ->build();
    }
}
