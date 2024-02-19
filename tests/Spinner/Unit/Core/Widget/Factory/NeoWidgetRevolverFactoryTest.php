<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\NeoWidgetRevolverFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class NeoWidgetRevolverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(NeoWidgetRevolverFactory::class, $widgetRevolverFactory);
    }

    public function getTesteeInstance(
        ?INeoWidgetRevolverBuilder $builder = null,
    ): IWidgetRevolverFactory
    {
        return new NeoWidgetRevolverFactory(
            builder: $builder ?? $this->getNeoWidgetRevolverBuilderMock(),
        );
    }

    private function getNeoWidgetRevolverBuilderMock(): INeoWidgetRevolverBuilder
    {
        return $this->createMock(INeoWidgetRevolverBuilder::class);
    }

}
