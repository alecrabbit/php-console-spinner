<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Tests\TestCase\TestCase;

final class PatternFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(PatternFactory::class, $pattern);
    }

    public function getTesteeInstance(): IPatternFactory
    {
        return new PatternFactory();
    }

}
