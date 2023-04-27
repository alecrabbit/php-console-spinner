<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Container\Override;

final class ClassForSpawnerWithParametersNoType
{
    public function __construct(
        public $object,
    ) {
    }
}
