<?php

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\IntervalNormalizer;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class IntervalNormalizerTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $container = $this->getContainerMock();
        $container
            ->method('get')
            ->willReturn(
                $this->getDefaultsProviderMock(),
            )
        ;
        $intervalFactory = $this->getTesteeInstance(container: $container);

        self::assertInstanceOf(IntervalNormalizer::class, $intervalFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IIntervalNormalizer {
        return
            new IntervalNormalizer(
                container: $container ?? $this->getContainerMock(),
            );
    }
}
