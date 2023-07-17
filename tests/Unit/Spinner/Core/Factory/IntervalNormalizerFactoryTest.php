<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerMethodOption;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class IntervalNormalizerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $intervalNormalizerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(IntervalNormalizerFactory::class, $intervalNormalizerFactory);
    }

    public function getTesteeInstance(
        ?IIntegerNormalizerBuilder $integerNormalizerBuilder = null,
        ?NormalizerMethodMode $normalizerMode = null,
    ): IIntervalNormalizerFactory {
        return new IntervalNormalizerFactory(
            integerNormalizerBuilder: $integerNormalizerBuilder ?? $this->getIntegerNormalizerBuilderMock(),
            normalizerMode: $normalizerMode ?? NormalizerMethodMode::BALANCED,
        );
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
