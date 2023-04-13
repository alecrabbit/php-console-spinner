<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\CharFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class CharFrameRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $charFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameRenderer::class, $charFrameRenderer);
    }

    public function getTesteeInstance(
        ?IFrameFactory $frameFactory = null,
    ): ICharFrameRenderer {
        return
            new CharFrameRenderer(
                frameFactory: $frameFactory ?? $this->getFrameFactoryMock(),
            );
    }
}
