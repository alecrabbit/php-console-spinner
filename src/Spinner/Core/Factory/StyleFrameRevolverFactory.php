<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

final readonly class StyleFrameRevolverFactory implements IStyleFrameRevolverFactory
{
    public function __construct(
        private IFrameCollectionRevolverBuilder $frameRevolverBuilder,
        private IFrameCollectionFactory $frameCollectionFactory,
        private IRevolverConfig $revolverConfig,
    ) {
    }

    /** @inheritDoc */
    public function legacyCreate(IPattern $pattern): IFrameRevolver
    {
        return $this->frameRevolverBuilder
            ->withFrames(
                $this->frameCollectionFactory->create(
                    $pattern->getFrames()
                )
            )
            ->withInterval(
                $pattern->getInterval()
            )
            ->withTolerance(
                $this->getTolerance()
            )
            ->build()
        ;
    }

    private function getTolerance(): ITolerance
    {
        return $this->revolverConfig->getTolerance();
    }

    public function create(IPalette $palette): IFrameRevolver
    {
        // TODO: Implement create() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
