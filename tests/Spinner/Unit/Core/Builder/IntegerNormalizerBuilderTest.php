<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Builder\IntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\IntegerNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class IntegerNormalizerBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $integerNormalizerBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(IntegerNormalizerBuilder::class, $integerNormalizerBuilder);
    }

    public function getTesteeInstance(): IIntegerNormalizerBuilder
    {
        return new IntegerNormalizerBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $divisor = 1;
        $min = 1;

        $integerNormalizerBuilder = $this->getTesteeInstance();
        $integerNormalizer = $integerNormalizerBuilder
            ->withDivisor($divisor)
            ->withMin($min)
            ->build()
        ;
        self::assertInstanceOf(IntegerNormalizer::class, $integerNormalizer);
        self::assertEquals($divisor, self::getPropertyValue($integerNormalizer, 'divisor'));
        self::assertEquals($min, self::getPropertyValue($integerNormalizer, 'min'));
    }
}
