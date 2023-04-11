<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

final class NotInContainerException extends ContainerException implements NotFoundExceptionInterface
{
}
