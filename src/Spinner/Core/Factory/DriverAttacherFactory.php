<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverAttacherFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverAttacher;

final class DriverAttacherFactory implements IDriverAttacherFactory
{
    protected static ?IDriverAttacher $attacher = null;

    public function __construct(
        protected ILoop $loop,
    ) {
    }

    public function getAttacher(): IDriverAttacher
    {
        if (null === self::$attacher) {
            self::$attacher = $this->createAttacher();
        }
        return self::$attacher;
    }

    protected function createAttacher(): IDriverAttacher
    {
        return
            new DriverAttacher($this->loop);
    }
}
