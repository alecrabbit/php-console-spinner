<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

final class NotInContainerException extends ContainerException implements NotFoundExceptionInterface
{
}
