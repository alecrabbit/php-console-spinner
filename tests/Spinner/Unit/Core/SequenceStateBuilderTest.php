<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\SequenceStateBuilder;
use AlecRabbit\Spinner\Core\SequenceState;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SequenceStateBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceStateBuilder::class, $builder);
    }

    public function getTesteeInstance(): ISequenceStateBuilder
    {
        return new SequenceStateBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $sequence = $this->getFaker()->word();
        $width = $this->getFaker()->numberBetween(1, 10);
        $previousWidth = $this->getFaker()->numberBetween(1, 10);

        $builder = $this->getTesteeInstance();

        $state =
            $builder
                ->withSequence($sequence)
                ->withWidth($width)
                ->withPreviousWidth($previousWidth)
                ->build()
        ;

        self::assertInstanceOf(SequenceState::class, $state);
        self::assertEquals($sequence, $state->getSequence());
        self::assertEquals($width, $state->getWidth());
        self::assertEquals($previousWidth, $state->getPreviousWidth());
    }

    #[Test]
    public function throwIfSequenceIsNotSet(): void
    {
        $width = $this->getFaker()->numberBetween(1, 10);
        $previousWidth = $this->getFaker()->numberBetween(1, 10);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Sequence is not set.');

        $this->getTesteeInstance()
            ->withWidth($width)
            ->withPreviousWidth($previousWidth)
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfWidthIsNotSet(): void
    {
        $sequence = $this->getFaker()->word();
        $previousWidth = $this->getFaker()->numberBetween(1, 10);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Width is not set.');

        $this->getTesteeInstance()
            ->withSequence($sequence)
            ->withPreviousWidth($previousWidth)
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfPreviousWidthIsNotSet(): void
    {
        $sequence = $this->getFaker()->word();
        $width = $this->getFaker()->numberBetween(1, 10);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Previous width is not set.');

        $this->getTesteeInstance()
            ->withSequence($sequence)
            ->withWidth($width)
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }
}
