<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Procedure\A\AProceduralPattern;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;

/**
 * TODO Needed for development purposes only.
 */
final class TmpProceduralCharPattern extends AProceduralPattern
{
    protected const INTERVAL = 500;

    public function getProcedure(): IProcedure
    {
        return new class() extends AProcedure {
            public function getFrame(?float $dt = null): IFrame
            {
                static $odd = true;
                $odd = !$odd;
                return CharFrameFactory::create($odd ? '⢸' : '⡇', 1);
            }
        };
    }
}
