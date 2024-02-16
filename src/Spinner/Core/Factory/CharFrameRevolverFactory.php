<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

final readonly class CharFrameRevolverFactory implements ICharFrameRevolverFactory
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

    public function create(IPalette $palette): IFrameRevolver
    {
        // TODO: Implement create() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
