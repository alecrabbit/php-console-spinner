<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Palette\Builder;

use AlecRabbit\Spinner\Core\Palette\Builder\Contract\IPaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Builder\PaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class PaletteTemplateBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();
        self::assertInstanceOf(PaletteTemplateBuilder::class, $builder);
    }

    private function getTesteeInstance(): IPaletteTemplateBuilder
    {
        return new PaletteTemplateBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $entries = $this->getTraversableMock();
        $options = $this->getPaletteOptionsMock();

        $template =
            $builder
                ->withEntries($entries)
                ->withOptions($options)
                ->build()
        ;

        self::assertInstanceOf(PaletteTemplate::class, $template);

        self::assertSame($entries, $template->getEntries());
        self::assertSame($options, $template->getOptions());
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function throwsIfEntriesAreNotSet(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Entries are not set.');

        $builder = $this->getTesteeInstance();
        $builder
            ->withOptions($this->getPaletteOptionsMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfOptionsAreNotSet(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Options are not set.');

        $builder = $this->getTesteeInstance();
        $builder
            ->withEntries($this->getTraversableMock())
            ->build()
        ;
    }
}
