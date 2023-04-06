<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class SpinnerAttacherFactory implements Contract\ISpinnerAttacherFactory
{
    protected static ?ISpinnerAttacher $attacher = null;

    public function __construct(
        protected ILoopFactory $loopFactory, // FIXME (2023-04-06 13:37) [Alec Rabbit]: depends on loop only
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
            new SpinnerAttacher($this->loopFactory->getLoop()); // FIXME (2023-04-06 13:37) [Alec Rabbit]: depends on loop only
    }
}
