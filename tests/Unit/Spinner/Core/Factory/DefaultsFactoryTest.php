<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\Helper\PickLock;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\Override\DefaultsOverride;
use stdClass;

//use AlecRabbit\Spinner\Config\Defaults\Defaults;

final class DefaultsFactoryTest extends TestCase
{
    private const DEFAULTS_CLASS_CAN_BE_SET_ONLY_ONCE =
        'Defaults class can be set only once - before first defaults instance is created.';

    /** @test */
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

    /** @test */
    public function setDefaultsClassThrowsOnSetRepeat(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(
            self::DEFAULTS_CLASS_CAN_BE_SET_ONLY_ONCE
        );

        $class = DefaultsOverride::class;
        DefaultsFactory::setDefaultsClass($class);
        DefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', DefaultsFactory::class));
    }

    /** @test */
    public function setDefaultsClassThrowsAfterDefaultInstanceCreation(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(
            self::DEFAULTS_CLASS_CAN_BE_SET_ONLY_ONCE
        );

        $defaults = self::getDefaultsInstance();
        $class = DefaultsOverride::class;
        DefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', DefaultsFactory::class));
        self::assertSame($defaults, self::getDefaultsInstance());
    }

    /** @test */
    public function defaultsClassCanBeSet(): void
    {
        $class = DefaultsOverride::class;
        DefaultsFactory::setDefaultsClass($class);
        self::assertSame($class, self::getValue('className', DefaultsFactory::class));
    }

    /** @test */
    public function setDefaultsClassThrowsOnInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s"',
                stdClass::class,
                IDefaults::class
            )
        );

        DefaultsFactory::setDefaultsClass(stdClass::class);
        self::assertTrue(is_subclass_of(DefaultsFactory::get()::class, IDefaults::class));
    }

    protected function setUp(): void
    {
        PickLock::setValue(DefaultsFactory::class, 'className', null);
    }
}

