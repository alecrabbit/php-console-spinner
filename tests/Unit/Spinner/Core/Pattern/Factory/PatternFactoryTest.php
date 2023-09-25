<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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

    #[Test]
    public function canCreate(): void
    {
        $factory = $this->getTesteeInstance();

        // TODO (2023-09-25 13:15) [Alec Rabbit]: implement [d807bad2-f76a-465d-9f3b-2dfa1e255885]
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not implemented.');

        self::assertInstanceOf(
            ITemplate::class,
            $factory->create($this->getPaletteMock())
        );
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }
}
