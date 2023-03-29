<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Core\Defaults\A\ADefaultsClasses;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AClassesTest extends TestCase
{
    /** @test */
    public function sameInstanceEverytime(): void
    {
        $iterations = self::REPEATS;

        $defaults = self::getTesteeInstance();

        for ($i = 0; $i < $iterations; $i++) {
            self::assertSame($defaults, self::getTesteeInstance());
        }
    }

    private static function getTesteeInstance(): IDefaultsClasses
    {
        return ADefaultsClasses::getInstance(StaticDefaultsFactory::get());
    }

    /** @test */

    /** @test */
    public function canSetWidgetBuilderClass(): void
    {
        $class = WidgetBuilder::class;
        $classes = self::getTesteeInstance();
        $classes->overrideWidgetBuilderClass($class);
        self::assertSame($class, $classes->getWidgetBuilderClass());
    }

    /** @test */
    public function canSetWidgetRevolverBuilderClass(): void
    {
        $class = WidgetRevolverBuilder::class;
        $classes = self::getTesteeInstance();
        $classes->overrideWidgetRevolverBuilderClass($class);
        self::assertSame($class, $classes->getWidgetRevolverBuilderClass());
    }

    /** @test */
    public function setWidgetBuilderClassThrowsOnInvalidArgument(): void
    {
        $invalidClass = WidgetRevolverBuilder::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s"',
                $invalidClass,
                IWidgetBuilder::class,
            )
        );

        $classes = self::getTesteeInstance();
        $classes->overrideWidgetBuilderClass($invalidClass);
        self::fail('Exception expected');
    }

    /** @test */
    public function setWidgetRevolverBuilderClassThrowsOnInvalidArgument(): void
    {
        $invalidClass = WidgetBuilder::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must be a subclass of "%s"',
                $invalidClass,
                IWidgetRevolverBuilder::class,
            )
        );

        $classes = self::getTesteeInstance();
        $classes->overrideWidgetRevolverBuilderClass($invalidClass);
        self::fail('Exception expected');
    }

    protected function setUp(): void
    {
        self::callMethod(self::getTesteeInstance(), 'reset');
    }
}
