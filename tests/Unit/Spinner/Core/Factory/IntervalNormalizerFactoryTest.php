<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
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
        ?NormalizerMode $normalizerMode = null,
    ): IIntervalNormalizerFactory {
        return new IntervalNormalizerFactory(
            integerNormalizerBuilder: $integerNormalizerBuilder ?? $this->getIntegerNormalizerBuilderMock(),
            normalizerMode: $normalizerMode ?? NormalizerMode::BALANCED,
        );
    }

    protected function getIntegerNormalizerBuilderMock(): MockObject&IIntegerNormalizerBuilder
    {
        return $this->createMock(IIntegerNormalizerBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $integerNormalizerBuilder = $this->getIntegerNormalizerBuilderMock();
        $integerNormalizerBuilder
            ->expects(self::once())
            ->method('withDivisor')
            ->willReturnSelf()
        ;
        $integerNormalizerBuilder
            ->expects(self::once())
            ->method('withMin')
            ->willReturnSelf()
        ;
        $integerNormalizerBuilder
            ->expects(self::once())
            ->method('build')
        ;
        $intervalNormalizerFactory =
            $this->getTesteeInstance(
                integerNormalizerBuilder: $integerNormalizerBuilder
            );

        self::assertInstanceOf(IntervalNormalizerFactory::class, $intervalNormalizerFactory);
        self::assertInstanceOf(IntervalNormalizer::class, $intervalNormalizerFactory->create());
    }
}
