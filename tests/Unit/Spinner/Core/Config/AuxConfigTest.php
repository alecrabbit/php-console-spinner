<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AuxConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfig::class, $config);
    }

    protected function getTesteeInstance(): IAuxConfig
    {
        return
            new AuxConfig();
    }
}
