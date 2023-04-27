<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Render\CharFrameRenderer;
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
        return new CharFrameRenderer(
            frameFactory: $frameFactory ?? $this->getFrameFactoryMock(),
        );
    }

    #[Test]
    public function canRender(): void
    {
        $str = 'test';

        $frameFactory = $this->getFrameFactoryMock();
        $frameMock = $this->getFrameMock();
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($frameMock)
        ;

        $charFrameRenderer = $this->getTesteeInstance(frameFactory: $frameFactory);
        self::assertSame($frameMock, $charFrameRenderer->render($str));
    }
}
