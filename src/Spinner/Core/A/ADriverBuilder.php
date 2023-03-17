<?php
declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;

abstract class ADriverBuilder implements \AlecRabbit\Spinner\Core\Contract\IDriverBuilder
{

    /**
     * @inheritDoc
     */
    public function build(): IDriver
    {
        // TODO: Implement build() method.
    }
}