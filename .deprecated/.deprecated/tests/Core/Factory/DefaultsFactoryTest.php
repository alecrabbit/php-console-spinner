<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config\Defaults\Override\ADefaultsOverride;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

//use AlecRabbit\Spinner\Config\Defaults\Defaults;

final class DefaultsFactoryTest extends TestCase
{
    #[Test]
    public function sameInstanceEverytime(): void
    {
        $iterations = self::REPEATS;

        $defaults = self::getDefaultsInstance();

        for ($i = 0; $i < $iterations; $i++) {
            self::assertSame($defaults, self::getDefaultsInstance());
        }
    }

    private static function getDefaultsInstance(): IDefaults
    {
        return StaticDefaultsFactory::get();
    }

    #[Test]
    public function setDefaultsClassThrowsAfterDefaultInstanceCreation(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(
            'Defaults class can not be set after defaults instance is created.'
        );

        $defaults = self::getDefaultsInstance();
        $class = ADefaultsOverride::class;
        StaticDefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', StaticDefaultsFactory::class));
        self::assertSame($defaults, self::getDefaultsInstance());
    }

    #[Test]
    public function defaultsClassCanBeSet(): void
    {
        $class = ADefaultsOverride::class;
        StaticDefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', StaticDefaultsFactory::class));
    }

    #[Test]
    public function setDefaultsClassThrowsOnInvalidArgument(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s"',
                stdClass::class,
                IDefaults::class
            )
        );

        StaticDefaultsFactory::setDefaultsClass(stdClass::class);
        self::exceptionNotThrown($exceptionClass);
    }

    protected function setUp(): void
    {
        self::setValue(StaticDefaultsFactory::class, 'className', null);
        self::setValue(StaticDefaultsFactory::class, 'defaultsInstance', null);
    }
}
