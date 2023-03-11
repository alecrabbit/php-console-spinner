<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Core\Pattern\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;
use AlecRabbit\Spinner\Exception\DomainException;

abstract class AProceduralPattern extends APattern implements IProceduralPattern
{
    /**
     * @throws DomainException
     */
    public function getPattern(): iterable
    {
        throw new DomainException(
            sprintf(
                '%s can not have %s method',
                static::class,
                __FUNCTION__
            )
        );
    }
}