<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\Override\DefaultsOverride;
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
        return DefaultsFactory::get();
    }

    #[Test]
    public function setDefaultsClassThrowsAfterDefaultInstanceCreation(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(
            'Defaults class can not be set after defaults instance is created.'
        );

        $defaults = self::getDefaultsInstance();
        $class = DefaultsOverride::class;
        DefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', DefaultsFactory::class));
        self::assertSame($defaults, self::getDefaultsInstance());
    }

    #[Test]
    public function defaultsClassCanBeSet(): void
    {
        $class = DefaultsOverride::class;
        DefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', DefaultsFactory::class));
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

        DefaultsFactory::setDefaultsClass(stdClass::class);
        self::exceptionNotThrown($exceptionClass);
    }

    protected function setUp(): void
    {
        self::setValue(DefaultsFactory::class, 'className', null);
        self::setValue(DefaultsFactory::class, 'defaultsInstance', null);
    }
}

