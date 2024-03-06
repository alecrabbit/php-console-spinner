<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Stub;

final class ClassForSpawnerWithParameters
{
    public function __construct(
        public ClassForSpawner $object,
    ) {
    }
}
