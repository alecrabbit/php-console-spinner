<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Override;

final class ClassForSpawnerWithParametersNoType
{
    public function __construct(
        public $object,
    ) {
    }
}
