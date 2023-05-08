<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProceduralStylePattern;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;

/**
 * TODO Needed for development purposes only.
 */
final class TmpProceduralStylePattern extends AProceduralStylePattern
{
    protected const INTERVAL = 1000;

    public function getProcedure(): IProcedure
    {
        return new class() extends AProcedure {
            public function getFrame(?float $dt = null): IFrame
            {
                static $odd = true;
                $odd = !$odd;
                return new CharFrame($odd ? '>%s>' : '<%s<', 2);
            }
        };
    }
}
