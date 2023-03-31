<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use ArrayObject;

final class RevolverFactory extends AFactory implements IRevolverFactory
{
    public function defaultStyleRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        $this->getFrameFactory()->create('%s', 0),
                    ])
                ),
                StaticIntervalFactory::createStill()
            );
    }

    public function create(IPattern $pattern): IRevolver
    {
        return $this->getFrameRevolverBuilder()->withPattern($pattern)->build();
    }

    protected function getFrameRevolverBuilder(): IFrameRevolverBuilder
    {
        return $this->container->get(IFrameRevolverBuilder::class);
    }

    protected function getFrameFactory(): IFrameFactory
    {
        return $this->container->get(IFrameFactory::class);
    }

    public function defaultCharRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        $this->getFrameFactory()::createEmpty(),
                    ])
                ),
                StaticIntervalFactory::createStill()
            );
    }
}
