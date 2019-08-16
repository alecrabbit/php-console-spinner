<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class Extended256BgSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = ['1', '2', '3', '4',];
    protected const
        STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 =>
                        [
                            [1, 1,],
                            [2, 2,],
                            [3, 3,],
                            [4, 4,],
                        ],
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];
}
