<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

class DriverConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function simpleTest(): void
    {
        $interruptMessage = 'interruptMessage1';
        $finalMessage = 'finalMessage1';

        $config =
            new DriverConfig(
                $interruptMessage,
                $finalMessage,
            );
        self::assertSame($interruptMessage, $config->getInterruptMessage());
        self::assertSame($finalMessage, $config->getFinalMessage());
    }

}
