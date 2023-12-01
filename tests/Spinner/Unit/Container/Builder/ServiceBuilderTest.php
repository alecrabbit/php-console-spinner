<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Builder;


use AlecRabbit\Spinner\Container\Builder\ServiceBuilder;
use AlecRabbit\Spinner\Container\Contract\IServiceBuilder;
use AlecRabbit\Spinner\Container\Service;
use AlecRabbit\Tests\TestCase\TestCase;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ServiceBuilderTest extends TestCase
{
    public static function canBuildDataProvider(): iterable
    {
        yield from [
            // [value, id, isStorable]
            [['value', 'id', false]],
            [['value', 'id', true]],
            [[new stdClass(), stdClass::class, true]],
            [[new stdClass(), stdClass::class, false]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceBuilder::class, $builder);
    }

    private function getTesteeInstance(): IServiceBuilder
    {
        return new ServiceBuilder();
    }

    #[Test]
    #[DataProvider('canBuildDataProvider')]
    public function canBuild(array $data): void
    {
        $builder = $this->getTesteeInstance();

        [$value, $id, $isStorable] = $data;

        $service = $builder
            ->withValue($value)
            ->withId($id)
            ->withIsStorable($isStorable)
            ->build()
        ;

        self::assertInstanceOf(Service::class, $service);
        self::assertSame($value, $service->getValue());
        self::assertSame($id, $service->getId());
        self::assertSame($isStorable, $service->isStorable());
    }

    #[Test]
    public function throwIfValueIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not set.');

        $builder
            ->withId('id')
            ->withIsStorable(false)
            ->build()
        ;
    }

    #[Test]
    public function throwIfIdIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Id is not set.');

        $builder
            ->withValue('value')
            ->withIsStorable(false)
            ->build()
        ;
    }

    #[Test]
    public function throwIfIsStorableIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('isStorable is not set.');

        $builder
            ->withValue('value')
            ->withId('id')
            ->build()
        ;
    }
}
