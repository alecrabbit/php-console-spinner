<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Contract\IProbesLoader;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopCreatorClassProviderFactory;
use AlecRabbit\Spinner\Core\Factory\LoopCreatorClassProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassProvider;
use AlecRabbit\Tests\Spinner\Unit\Asynchronous\Stub\LoopCreatorStub;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class LoopCreatorClassProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopCreatorClassProviderFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?ILoopCreatorClassExtractor $loopCreatorClassExtractor = null,
        ?IProbesLoader $probesLoader = null,
    ): ILoopCreatorClassProviderFactory&IInvokable {
        return new LoopCreatorClassProviderFactory(
            loopCreatorClassExtractor: $loopCreatorClassExtractor ?? $this->getLoopCreatorClassExtractorMock(),
            probesLoader: $probesLoader ?? $this->getProbesLoaderMock(),
        );
    }

    private function getLoopCreatorClassExtractorMock(): MockObject&ILoopCreatorClassExtractor
    {
        return $this->createMock(ILoopCreatorClassExtractor::class);
    }

    private function getProbesLoaderMock(): MockObject&IProbesLoader
    {
        return $this->createMock(IProbesLoader::class);
    }

    #[Test]
    public function canInvoke(): void
    {
        $probes = $this->createMock(Traversable::class);
        $probesLoader = $this->getProbesLoaderMock();
        $probesLoader
            ->expects($this->once())
            ->method('load')
            ->with(self::identicalTo(ILoopProbe::class))
            ->willReturn($probes)
        ;

        $loopCreatorClassExtractor = $this->getLoopCreatorClassExtractorMock();
        $loopCreatorClassExtractor
            ->expects($this->once())
            ->method('extract')
            ->with(self::identicalTo($probes))
            ->willReturn(LoopCreatorStub::class)
        ;

        $factory = $this->getTesteeInstance(
            loopCreatorClassExtractor: $loopCreatorClassExtractor,
            probesLoader: $probesLoader,
        );

        $provider = $factory();

        self::assertInstanceOf(LoopCreatorClassProvider::class, $provider);
    }
}
