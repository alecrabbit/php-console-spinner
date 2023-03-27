<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Spinner\Core\Container\Contract;

use Psr\Container\ContainerInterface;

interface IContainer extends ContainerInterface
{
    /** @inheritdoc */
    public function get(string $id): object;

    /** @inheritdoc */
    public function has(string $id): bool;
}