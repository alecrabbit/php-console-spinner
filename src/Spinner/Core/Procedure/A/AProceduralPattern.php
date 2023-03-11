<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Procedure\A;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProceduralPattern;
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