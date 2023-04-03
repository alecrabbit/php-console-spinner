<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ICursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Factory\CursorFactory;
use AlecRabbit\Spinner\Core\Output\Cursor;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;


final class CursorFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $cursorFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CursorFactory::class, $cursorFactory);
    }

    public function getTesteeInstance(
        ?IDefaultsProvider $defaultsProvider = null,
        ?IOutputFactory $outputFactory = null,
    ): ICursorFactory {
        return
            new CursorFactory(
                defaultsProvider: $defaultsProvider ?? $this->prepareDefaultsProviderMock(),
                outputFactory:  $outputFactory ?? $this->prepareOutputFactoryMock(),
            );
    }

    private function prepareDefaultsProviderMock(): MockObject&IDefaultsProvider
    {
        $auxSettings = $this->getAuxSettingsMock();
        $auxSettings
            ->method('getCursorOption')
            ->willReturn(OptionCursor::ENABLED);

        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->method('getAuxSettings')
            ->willReturn($auxSettings);

        return $defaultsProvider;
    }

    protected function prepareOutputFactoryMock(): MockObject&IOutputFactory
    {
        $outputFactory = $this->getOutputFactoryMock();
        $outputFactory
            ->method('getOutput')
            ->willReturn($this->getBufferedOutputMock());

        return $outputFactory;
    }

    #[Test]
    public function canCreateCursor(): void
    {
        $cursorFactory = $this->getTesteeInstance();

        self::assertInstanceOf(Cursor::class, $cursorFactory->createCursor());
    }
}
