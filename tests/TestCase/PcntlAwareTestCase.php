<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Tests\TestCase\Helper\PickLock;
use AlecRabbit\Tests\TestCase\Mixin\AppRelatedConstTrait;
use ArrayAccess;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Throwable;

use function array_key_exists;
use function is_array;
use function is_string;

abstract class PcntlAwareTestCase extends TestCase
{
    protected function isPcntlExtensionAvailable(): bool
    {
        return function_exists('pcntl_signal');
    }
}
