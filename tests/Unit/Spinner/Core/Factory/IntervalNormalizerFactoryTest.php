<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizerBuilder;
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
        ?OptionNormalizerMode $normalizerMode = null,
    ): IIntervalNormalizerFactory {
        return
            new IntervalNormalizerFactory(
                integerNormalizerBuilder: $integerNormalizerBuilder ?? $this->getIntegerNormalizerBuilder(),
                normalizerMode: $normalizerMode ?? OptionNormalizerMode::BALANCED,
            );
    }


    #[Test]
    public function canCreate(): void
    {
        $integerNormalizerBuilder = $this->getIntegerNormalizerBuilder();
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
