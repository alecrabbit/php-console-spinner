<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IIntNormalizer;
use AlecRabbit\Spinner\Core\Factory\A\AIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\IntNormalizer;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AIntervalFactoryTest extends TestCase
{
    #[Test]
    public function canCreateDefaultInterval(): void
    {
        $defaults = DefaultsFactory::create();

        self::assertEquals(
            $defaults->getIntervalMilliseconds(),
            AIntervalFactory::createDefault()->toMilliseconds()
        );
    }

    protected function setUp(): void
    {
        IntNormalizer::setDivisor(IIntNormalizer::DEFAULT_DIVISOR);
    }
}
