<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Service;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ServiceTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $service = $this->getTesteeInstance();

        self::assertInstanceOf(Service::class, $service);
    }

    protected function getTesteeInstance(
        mixed $value = null,
        ?bool $storable = null,
    ): IService {
        return
            new Service(
                value: $value,
                storable: $storable ?? false,
            );
    }

    #[Test]
    public function canGetValue(): void
    {
        $value = new stdClass();

        $service = $this->getTesteeInstance(
            value: $value,
        );

        self::assertSame($value, $service->getValue());
    }

    #[Test]
    public function canGetStorable(): void
    {
        $service = $this->getTesteeInstance(
            storable: true,
        );

        self::assertTrue($service->isStorable());
    }
}
