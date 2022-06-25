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
        $twirlers = self::getValue('twirlers', from: $container);
        self::assertCount(0, $twirlers);
        self::assertEmpty($twirlers);
    }

    /** @test */
    public function canAcceptTwirlers(): void
    {
        $config = self::getDefaultConfig();
        $twirler = self::getDefaultTwirler($config);
        $spinner = new MultiSpinner($config);
        $spinner->add($twirler);
        $container = self::getValue('container', from: $spinner);
        $twirlers = self::getValue('twirlers', from: $container);
        self::assertCount(1, $twirlers);
        self::assertNotEmpty($twirlers);
        self::assertContains($twirler, $twirlers);
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
