<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Stub;

final class ClassForSpawnerWithParametersNoType
{
    public function __construct(
        public $object,
    ) {
    }
}
