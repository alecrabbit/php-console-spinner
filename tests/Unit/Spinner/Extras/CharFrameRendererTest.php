<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras;

use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\CharFrameRenderer;
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
        ?ICharFrameFactory $frameFactory = null,
    ): ICharFrameRenderer {
        return new CharFrameRenderer(
            frameFactory: $frameFactory ?? $this->getCharFrameFactoryMock(),
        );
    }

    #[Test]
    public function canRender(): void
    {
        $str = 'test';

        $frameFactory = $this->getCharFrameFactoryMock();
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
