<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Core\Defaults\A\AClasses;
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

        $defaults = self::getInstance();

        for ($i = 0; $i < $iterations; $i++) {
            self::assertSame($defaults, self::getInstance());
        }
    }

    private static function getInstance(): AClasses
    {
        return AClasses::getInstance();
    }

    /** @test */

    /** @test */
    public function canSetWidgetBuilderClass(): void
    {
        $class = WidgetBuilder::class;
        $classes = self::getInstance();
        $classes->setWidgetBuilderClass($class);
        self::assertSame($class, $classes->getWidgetBuilderClass());
    }

    /** @test */
    public function canSetWidgetRevolverBuilderClass(): void
    {
        $class = WidgetRevolverBuilder::class;
        $classes = self::getInstance();
        $classes->setWidgetRevolverBuilderClass($class);
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

        $classes = self::getInstance();
        $classes->setWidgetBuilderClass($invalidClass);
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

        $classes = self::getInstance();
        $classes->setWidgetRevolverBuilderClass($invalidClass);
        self::fail('Exception expected');
    }

    protected function setUp(): void
    {
        self::getInstance()->reset();
    }
    // 'Class "AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder" must be a subclass of "AlecRabbit\Spinner\Core\Widget\Builder\Contract\IWidgetBuilder"'
    // 'Class "AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder" must be a subclass of "AlecRabbit\Spinner\Core\Widget\WidgetBuilder"'.
}
