<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Contract\IReference;
use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ReferenceTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $reference = $this->getTesteeInstance();

        self::assertInstanceOf(Reference::class, $reference);
    }

    protected function getTesteeInstance(
        ?string $id = null,
    ): IReference {
        return
            new Reference(
                id: $id ?? self::getFaker()->word(),
            );
    }

    #[Test]
    public function canToString(): void
    {
        $id = self::getFaker()->word();
        $reference = $this->getTesteeInstance(
            id: $id
        );

        self::assertSame($id, (string)$reference);
    }
}
