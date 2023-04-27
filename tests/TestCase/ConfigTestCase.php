<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\StaticFacade;

abstract class ConfigTestCase extends TestCase
{
    protected static ?IConfig $config = null;

    /**
     * @param bool $fresh Set to true to create a fresh config during one test.
     *
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected static function getDefaultConfig(bool $fresh = false): IConfig
    {
        if ($fresh) {
            return self::doBuildConfig();
        }

        if (self::$config === null) {
            // creates a reusable config for one test
            self::$config = self::doBuildConfig();
        }
        return self::$config;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function doBuildConfig(): IConfig
    {
        return self::getConfigBuilder()
            ->build()
        ;
    }

    protected static function getConfigBuilder(): IConfigBuilder
    {
        return StaticFacade::getConfigBuilder();
    }

    protected function tearDown(): void
    {
        self::$config = null; // Reset config after each test.
    }
}
