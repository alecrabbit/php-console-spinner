<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Contract\IProbesLoader;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopCreatorClassProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassProvider;

final readonly class LoopCreatorClassProviderFactory implements ILoopCreatorClassProviderFactory, IInvokable
{
    public function __construct(
        private ILoopCreatorClassExtractor $loopCreatorClassExtractor,
        private IProbesLoader $probesLoader,
    ) {
    }

    public function __invoke(): ILoopCreatorClassProvider
    {
        return new LoopCreatorClassProvider(
            $this->getCreatorClass(),
        );
    }

    /**
     * @return class-string<ICreator>|null
     */
    private function getCreatorClass(): ?string
    {
        return $this->loopCreatorClassExtractor->extract(
            $this->probesLoader->load(ILoopProbe::class)
        );
    }
}
