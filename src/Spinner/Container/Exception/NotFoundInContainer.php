<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

final class NotFoundInContainer extends ContainerException implements NotFoundExceptionInterface
{
}
