<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\FrameCollectionFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class FrameCollectionFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
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
                new \ArrayObject([
                    new CharFrame('a', 1),
                ])
            )
        );
    }
}
