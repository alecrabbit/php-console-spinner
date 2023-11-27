<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use RuntimeException;

abstract class ConfigurationTestCase extends ContainerModifyingTestCase
{
    protected static function getRequiredConfig(string $class): IConfigElement
    {
        $config = self::getFacadeContainer()->get($class);
        if ($config instanceof IConfigElement && is_a($config, $class, true)) {
            return $config;
        }
        throw new RuntimeException('Unable to get required config: ' . $class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        static::performContainerModifications();
    }

    abstract protected static function performContainerModifications(): void;


}
