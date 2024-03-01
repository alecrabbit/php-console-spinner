<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopCreatorClassProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassProvider;
use AlecRabbit\Spinner\Probes;
use Traversable;

final readonly class LoopCreatorClassProviderFactory implements ILoopCreatorClassProviderFactory, IInvokable
{
    private ?string $creatorClass;

    public function __construct(
        ILoopCreatorClassExtractor $loopCreatorClassExtractor,
    ) {
        $this->creatorClass = $loopCreatorClassExtractor->extract($this->loadProbes());
    }

    private function loadProbes(): Traversable
    {
        return Probes::load(ILoopProbe::class);
    }

    public function __invoke(): ILoopCreatorClassProvider
    {
        return new LoopCreatorClassProvider(
            $this->creatorClass,
        );
    }
}
