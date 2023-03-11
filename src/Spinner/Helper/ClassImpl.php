<?php

declare(strict_types=1);
// 11.03.23
namespace AlecRabbit\Spinner\Helper;

final class ClassImpl extends AClass
{
    private function __construct()
    {
        $this->value = 'value';
    }

    public static function getInstance(): self
    {
        return new self();
    }
}