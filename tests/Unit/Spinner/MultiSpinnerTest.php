<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\MultiSpinner;
use AlecRabbit\Tests\Spinner\TestCase;

final class MultiSpinnerTest extends TestCase
{
    /** @test */
    public function createdEmpty(): void
    {
        $config = self::getDefaultConfig();
        $spinner = new MultiSpinner($config);
        $container = self::getValue('container', from: $spinner);
        $contexts = self::getValue('contexts', from: $container);
        self::assertCount(0, $contexts);
        self::assertEmpty($contexts);
    }

    /** @test */
    public function canAcceptTwirlers(): void
    {
        $config = self::getDefaultConfig();
        $twirler = self::getDefaultTwirler($config);
        $spinner = new MultiSpinner($config);
        $spinner->add($twirler);
        $container = self::getValue('container', from: $spinner);
        $contexts = self::getValue('contexts', from: $container);
        self::assertCount(1, $contexts);
        self::assertNotEmpty($contexts);
        self::assertSame($twirler, $contexts[0]->twirler);
    }

    protected static function getDefaultTwirler(?IConfig $config = null): ITwirler
    {
        $config = $config ?? self::getDefaultConfig();
        return
            $config
                ->getTwirlerBuilder()
                ->build()
        ;
    }

}
