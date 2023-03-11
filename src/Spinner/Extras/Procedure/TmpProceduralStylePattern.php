<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProceduralStylePattern;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IProcedure;

/**
 * TODO move(and rename) this class to Extras package?
 */
final class TmpProceduralStylePattern extends AProceduralStylePattern
{
    protected const UPDATE_INTERVAL = 1000;

    public function getProcedure(): IProcedure
    {
        return new class() extends AProcedure {
            public function update(float $dt = null): IFrame
            {
                static $odd = true;
                $odd = !$odd;
                return new Frame($odd ? '>%s>' : '<%s<', 2);
            }
        };
    }
}