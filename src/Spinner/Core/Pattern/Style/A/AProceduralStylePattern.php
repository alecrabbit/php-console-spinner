<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IProceduralPattern;

abstract class AProceduralStylePattern extends AStylePattern implements IProceduralPattern
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