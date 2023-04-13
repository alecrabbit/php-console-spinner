<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Render;

use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\StyleRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class StyleRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleRenderer::class, $styleFrameRenderer);
    }

    public function getTesteeInstance(): IStyleRenderer
    {
        return
            new StyleRenderer();
    }
}
