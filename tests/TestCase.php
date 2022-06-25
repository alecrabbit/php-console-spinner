<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Tests\Spinner\Helper\PickLock;
use ArrayAccess;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

use function array_key_exists;
use function is_array;

abstract class TestCase extends PHPUnitTestCase
{
    final protected const ARGUMENTS = 'arguments';
    final protected const BUILDER = 'builder';
    final protected const CHAR_PATTERN = 'charPattern';
    final protected const CLASS_ = 'class';
    final protected const CONTAINS = 'contains';
    final protected const COUNT = 'count';
    final protected const EXCEPTION = 'exception';
    final protected const EXTRACTED = 'extracted';
    final protected const INTERVAL = 'interval';
    final protected const MESSAGE = 'message';
    final protected const PATTERN = 'pattern';
    final protected const PREFERRED_INTERVAL = 'preferredInterval';
    final protected const RENDERED = 'rendered';
    final protected const PROVIDED = 'provided';
    final protected const RESULT = 'result';
    final protected const SEQUENCE = 'sequence';
    final protected const SEQUENCE_START = 'sequenceStart';
    final protected const SEQUENCE_END = 'sequenceEnd';
    final protected const STYLE_PATTERN = 'stylePattern';
    final protected const WITH = 'with';

    private static ?IConfig $config = null;

    /**
     * @param bool $fresh Set to true to create a fresh config during one test.
     *
     * @return IConfig
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected static function getDefaultConfig(bool $fresh = false): IConfig
    {
        if ($fresh) {
            return self::doBuildConfig();
        }

        if (null === self::$config) {
            // creates a reusable config for one test
            self::$config = self::doBuildConfig();
        }
        return
            self::$config;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private static function doBuildConfig(): IConfig
    {
        return
            self::getConfigBuilder()
                ->build()
        ;
    }

    protected static function getConfigBuilder(): ConfigBuilder
    {
        return new ConfigBuilder();
    }

    protected static function getValue(string $property, mixed $from): mixed
    {
        return PickLock::getValue($from, $property);
    }

    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
        self::$config = null; // Reset config after each test.
    }

    protected function setExpectException(mixed $expected): void
    {
        if ((is_array($expected) || $expected instanceof ArrayAccess)
            && array_key_exists(self::EXCEPTION, $expected)) {
            $this->expectException($expected[self::EXCEPTION][self::CLASS_]);
            if (array_key_exists(self::MESSAGE, $expected[self::EXCEPTION])) {
                $this->expectExceptionMessage($expected[self::EXCEPTION][self::MESSAGE]);
            }
        }
    }
}
