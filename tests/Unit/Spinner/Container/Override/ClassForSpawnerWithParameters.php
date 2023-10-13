<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container\Override;

final class ClassForSpawnerWithParameters
{
    public function __construct(
        public ClassForSpawner $object,
    ) {
    }
}
