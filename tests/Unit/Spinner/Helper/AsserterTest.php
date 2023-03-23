<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public static function intColorDataProvider(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI8 color mode value should be in range 0..255, 345 given.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => 345,
                ],
            ],
        ];
        #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be positive integer, -3 given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => -3,
                ],
            ],
        ];
        #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI4 color mode value should be in range 0..15, 22 given.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI4,
                    self::COLOR => 22,
                ],
            ],
        ];
    }

    public static function hexStringColorDataProvider(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be a valid hex color code("#rgb", "#rrggbb"), "ffee12" given. No',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR => 'ffee12',
                ],
            ],
        ];
        #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be a valid hex color code("#rgb", "#rrggbb"), "#ffe12" given. Length',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR => '#ffe12',
                ],
            ],
        ];
        #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should not be empty string.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR => '',
                ],
            ],
        ];
        #3
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be a valid hex color code("#rgb", "#rrggbb"), "#f2" given. Length',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR => '#f2',
                ],
            ],
        ];
        #4
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be a valid hex color code("#rgb", "#rrggbb"), "#ff" given. Length',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR => '#FF',
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('intColorDataProvider')]
    public function canAssertIntColor(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        Asserter::assertIntColor($args[self::COLOR], $args[self::MODE]);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }
    }
    #[Test]
    #[DataProvider('hexStringColorDataProvider')]
    public function canAssertHexColor(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        Asserter::assertHexStringColor($args[self::COLOR]);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }
    }
}
