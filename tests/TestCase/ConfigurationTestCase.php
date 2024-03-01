<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use RuntimeException;

abstract class ConfigurationTestCase extends ContainerModifyingTestCase
{
    protected static function getRequiredConfig(string $class): IConfigElement
    {
        $config = self::getService($class);
        if ($config instanceof IConfigElement && is_a($config, $class, true)) {
            return $config;
        }
        throw new RuntimeException('Unable to get required config: ' . $class);
    }

    protected static function getService(string $id): mixed
    {
        return self::getCurrentContainer()->get($id);
    }
}
