<?php

declare(strict_types=1);
// 02.04.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Container\Override;

final class ClassForSpawnerWithParameters
{
    public function __construct(
        public ClassForSpawner $object,
    ) {
    }
}