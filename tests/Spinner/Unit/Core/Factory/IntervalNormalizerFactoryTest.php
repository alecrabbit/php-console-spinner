<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Contract\IDivisorProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class IntervalNormalizerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $intervalNormalizerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalNormalizerFactory::class, $intervalNormalizerFactory);
    }

    public function getTesteeInstance(
        ?IIntegerNormalizerBuilder $integerNormalizerBuilder = null,
        ?IDivisorProvider $divisorProvider = null,
        ?INormalizerConfig $normalizerConfig = null,
    ): IIntervalNormalizerFactory {
        return new IntervalNormalizerFactory(
            integerNormalizerBuilder: $integerNormalizerBuilder ?? $this->getIntegerNormalizerBuilderMock(),
            divisorProvider: $divisorProvider ?? $this->getDivisorProviderMock(),
            normalizerConfig: $normalizerConfig ?? $this->getNormalizerConfigMock(),
        );
    }

    protected function getIntegerNormalizerBuilderMock(): MockObject&IIntegerNormalizerBuilder
    {
        return $this->createMock(IIntegerNormalizerBuilder::class);
    }

    private function getDivisorProviderMock(): MockObject&IDivisorProvider
    {
        return $this->createMock(IDivisorProvider::class);
    }

    private function getNormalizerConfigMock(?NormalizerMode $normalizerMode = null): MockObject&INormalizerConfig
    {
        $normalizerMode ??= NormalizerMode::BALANCED;
        $mock = $this->createMock(INormalizerConfig::class);
        $mock
            ->method('getNormalizerMode')
            ->willReturn($normalizerMode)
        ;
        return $mock;
    }

    #[Test]
    public function canCreate(): void
    {
        $mode = NormalizerMode::PERFORMANCE;
        $divisor = 100;

        $divisorProvider = $this->getDivisorProviderMock();
        $divisorProvider
            ->expects(self::once())
            ->method('getDivisor')
            ->with($mode)
            ->willReturn($divisor)
        ;

        $integerNormalizerBuilder = $this->getIntegerNormalizerBuilderMock();
        $integerNormalizerBuilder
            ->expects(self::once())
            ->method('withDivisor')
            ->with($divisor)
            ->willReturnSelf()
        ;
        $integerNormalizerBuilder
            ->expects(self::once())
            ->method('withMin')
            ->with($divisor)
            ->willReturnSelf()
        ;
        $integerNormalizerBuilder
            ->expects(self::once())
            ->method('build')
        ;
        $intervalNormalizerFactory =
            $this->getTesteeInstance(
                integerNormalizerBuilder: $integerNormalizerBuilder,
                divisorProvider: $divisorProvider,
                normalizerConfig: $this->getNormalizerConfigMock($mode),
            );

        self::assertInstanceOf(IntervalNormalizerFactory::class, $intervalNormalizerFactory);
        self::assertInstanceOf(IntervalNormalizer::class, $intervalNormalizerFactory->create($mode));
    }
}
