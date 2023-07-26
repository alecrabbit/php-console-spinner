<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Functional\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\OutputConfig;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class OutputConfigTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(OutputConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?StylingMethodMode $stylingMethodMode = null,
        ?CursorVisibilityMode $cursorVisibilityMode = null,
    ): IOutputConfig {
        return
            new OutputConfig(
                stylingMethodMode: $stylingMethodMode ?? StylingMethodMode::ANSI8,
                cursorVisibilityMode: $cursorVisibilityMode ?? CursorVisibilityMode::HIDDEN,
            );
    }

    #[Test]
    public function canGetStylingMethodMode(): void
    {
        $stylingMethodMode = StylingMethodMode::ANSI4;

        $config = $this->getTesteeInstance(
            stylingMethodMode: $stylingMethodMode,
        );

        self::assertSame($stylingMethodMode, $config->getStylingMethodMode());
    }

    #[Test]
    public function canGetCursorVisibilityMode(): void
    {
        $cursorVisibilityMode = CursorVisibilityMode::VISIBLE;

        $config = $this->getTesteeInstance(
            cursorVisibilityMode: $cursorVisibilityMode,
        );

        self::assertSame($cursorVisibilityMode, $config->getCursorVisibilityMode());
    }
}
