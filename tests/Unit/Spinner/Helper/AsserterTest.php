<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Helper;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Throwable;

final class AsserterTest extends TestCase
{
    #[Test]
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

        Asserter::isSubClass($invalidClass, $expectedClass); // Note: no caller method
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    #[Test]
    public function canAssertSubClassWithMethodName(): void
    {
        $invalidClass = stdClass::class;
        $expectedClass = Throwable::class;
        $exceptionClass = InvalidArgumentException::class;
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s", see "%s()"',
                $invalidClass,
                $expectedClass,
                __METHOD__,
            )
        );

        Asserter::isSubClass($invalidClass, $expectedClass, __METHOD__);
        self::exceptionNotThrown($exceptionClass);
    }

    #[Test]
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

    #[Test]
    public function canAssertColorSupportLevelsNotEmpty(): void
    {
        $invalidColorSupportLevels = new ArrayObject([]);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Color modes must not be empty.');

        Asserter::assertColorModes($invalidColorSupportLevels);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    #[Test]
    public function canAssertColorSupportLevels(): void
    {
        $invalidMode = 1;
        $invalidColorModes = new ArrayObject([$invalidMode]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported color mode of type "int".');

        Asserter::assertColorModes($invalidColorModes);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    #[Test]
    public function canAssertExtensionIsLoaded(): void
    {
        $extension = 'invalid_extension';
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Extension "%s" is not loaded.',
                $extension,
            )
        );

        Asserter::assertExtensionLoaded($extension);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }

    #[Test]
    public function canAssertClassNotExists(): void
    {
        $nonExistentClass = 'invalid_class';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" does not exist.',
                $nonExistentClass,
            )
        );

        Asserter::assertClassExists($nonExistentClass);
        self::fail(sprintf('[%s] Exception not thrown', __METHOD__));
    }
}
