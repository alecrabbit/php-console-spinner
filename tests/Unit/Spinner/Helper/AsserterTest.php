<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Helper;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use stdClass;
use Throwable;

use const AlecRabbit\Spinner\KNOWN_TERM_COLOR;

final class AsserterTest extends TestCase
{
    /** @test */
    public function canAssertSubClass(): void
    {
        $invalidClass = stdClass::class;
        $expectedClass = Throwable::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s"',
                $invalidClass,
                $expectedClass,
            )
        );

        Asserter::isSubClass($invalidClass, $expectedClass);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    /** @test */
    public function canAssertSubClassWithMethodName(): void
    {
        $invalidClass = stdClass::class;
        $expectedClass = Throwable::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s", in "%s()"',
                $invalidClass,
                $expectedClass,
                __METHOD__,
            )
        );

        Asserter::isSubClass($invalidClass, $expectedClass, __METHOD__);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    /** @test */
    public function canAssertStream(): void
    {
        $invalidStream = 1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Argument is expected to be a stream(resource), "%s" given.',
                get_debug_type($invalidStream),
            )
        );

        Asserter::assertStream($invalidStream);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    /** @test */
    public function canAssertColorSupportLevelsNotEmpty(): void
    {
        $invalidColorSupportLevels = [];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Color support levels must not be empty.',
            )
        );

        Asserter::assertColorSupportLevels($invalidColorSupportLevels);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    /** @test */
    public function canAssertColorSupportLevels(): void
    {
        $invalidLevel = 1;
        $invalidColorSupportLevels = [$invalidLevel];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Color support level "%s" is not allowed. Allowed values are [%s].',
                $invalidLevel,
                implode(', ', KNOWN_TERM_COLOR),
            )
        );

        Asserter::assertColorSupportLevels($invalidColorSupportLevels);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }
}
