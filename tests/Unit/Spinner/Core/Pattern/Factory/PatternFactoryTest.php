<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Template;
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
        $entries = new \ArrayObject();

        $factory = $this->getTesteeInstance();

        $palette = $this->getPaletteMock();
        $palette
            ->expects(self::once())
            ->method('getEntries')
            ->with(self::isInstanceOf(IPaletteOptions::class))
            ->willReturn($entries);

        $template = $factory->create($palette);

        self::assertInstanceOf(Template::class, $template);
        self::assertSame($entries, $template->getFrames());
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }
}
