<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;
use AlecRabbit\Spinner\Core\Procedure\A\AProcedure;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;

/**
 * TODO move(and rename) this class to Extras package
 */
final class TmpProceduralStyle extends AStylePattern
{
    protected const UPDATE_INTERVAL = 500;

    public function getPattern(): iterable|IProcedure
    {
        return new class() extends AProcedure {
            public function update(float $dt = null): IFrame
            {
                return new Frame('>%s<', 2);
            }
        };
    }
}