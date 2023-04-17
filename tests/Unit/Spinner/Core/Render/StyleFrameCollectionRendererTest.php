<?php

declare(strict_types=1);

// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Core\Render\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleFrameCollectionRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $collectionRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameCollectionRenderer::class, $collectionRenderer);
    }

    public function getTesteeInstance(
        ?IStyleFrameRendererFactory $styleFrameRendererFactory = null,
        ?IStyleFactory $styleFactory = null,
    ): IStyleFrameCollectionRenderer {
        return
            new StyleFrameCollectionRenderer(
                styleFrameRendererFactory: $styleFrameRendererFactory ?? $this->getStyleFrameRendererFactoryMock(),
                styleFactory: $styleFactory ?? $this->getStyleFactoryMock(),
            );
    }
}
