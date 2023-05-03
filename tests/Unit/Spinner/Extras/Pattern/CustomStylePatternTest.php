<?php

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Pattern;

use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Extras\Pattern\CustomStylePattern;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class CustomStylePatternTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(CustomStylePattern::class, $factory);
    }

    public function getTesteeInstance(
        ?array $pattern = null,
    ): IStylePattern {
        return new CustomStylePattern(
            pattern: $pattern ?? [],
        );
    }
}
