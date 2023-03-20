<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Extras\Procedure\A\AProceduralPattern;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;

/**
 * TODO move(and rename) this class to Extras package?
 */
final class TmpProceduralCharPattern extends AProceduralPattern
{
    protected const UPDATE_INTERVAL = 500;

    public function getProcedure(): IProcedure
    {
        return
            new class () extends AProcedure {
                public function update(float $dt = null): IFrame
                {
                    static $odd = true;
                    $odd = !$odd;
                    return
                        FrameFactory::create($odd ? '⢸' : '⡇', 1);
                }
            };
    }
}
