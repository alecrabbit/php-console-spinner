<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final class SpinnerAttacherFactory implements ISpinnerAttacherFactory
{
    protected static ?ISpinnerAttacher $attacher = null;

    public function __construct(
        protected ILoop $loop,
    ) {
    }

    public function getAttacher(): ISpinnerAttacher
    {
        if (null === self::$attacher) {
            self::$attacher = $this->createAttacher();
        }
        return self::$attacher;
    }

    protected function createAttacher(): ISpinnerAttacher
    {
        return
            new SpinnerAttacher($this->loop);
    }
}
