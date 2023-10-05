<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ToleranceTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(Tolerance::class, $config);
    }

    protected function getTesteeInstance(?int $value = null): ITolerance
    {
        if ($value === null) {
            return
                new Tolerance();
        }

        return
            new Tolerance(
                value: $value,
            );
    }

    #[Test]
    public function canGetValue(): void
    {
        $config = $this->getTesteeInstance();

        self::assertSame(5, $config->toMilliseconds());
    }
}
