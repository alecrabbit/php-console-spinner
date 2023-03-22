<?php

declare(strict_types=1);
// 11.03.23

namespace AlecRabbit\Spinner\Extras\Procedure\Mixin;

use AlecRabbit\Spinner\Exception\DomainException;
use Traversable;

trait GetPatternMethodNotAllowedTrait
{
    /**
     * @throws DomainException
     */
    final public function getPattern(): Traversable
    {
        throw new DomainException(
            sprintf(
                '%s can not have %s() method by design.',
                static::class,
                __FUNCTION__
            )
        );
    }
}
