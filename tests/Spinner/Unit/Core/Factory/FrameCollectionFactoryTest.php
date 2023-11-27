<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class FrameCollectionFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameCollectionFactory = $this->getTesteeInstance();

        self::assertInstanceOf(FrameCollectionFactory::class, $frameCollectionFactory);
    }

    public function getTesteeInstance(): IFrameCollectionFactory
    {
        return new FrameCollectionFactory();
    }

    #[Test]
    public function canCreateCollection(): void
    {
        $frameCollectionFactory = $this->getTesteeInstance();

        self::assertInstanceOf(FrameCollectionFactory::class, $frameCollectionFactory);
        self::assertInstanceOf(
            FrameCollection::class,
            $frameCollectionFactory->create(
                new ArrayObject([
                    new CharFrame('a', 1),
                ])
            )
        );
    }
}
