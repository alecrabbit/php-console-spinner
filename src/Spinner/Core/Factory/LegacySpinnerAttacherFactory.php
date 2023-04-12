<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\LegacySpinnerAttacher;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final class LegacySpinnerAttacherFactory implements ILegacySpinnerAttacherFactory
{
    protected static ?ILegacySpinnerAttacher $attacher = null;

    public function __construct(
        protected ILoop $loop,
    ) {
    }

    public function getAttacher(): ILegacySpinnerAttacher
    {
        if (null === self::$attacher) {
            self::$attacher = $this->createAttacher();
        }
        return self::$attacher;
    }

    protected function createAttacher(): ILegacySpinnerAttacher
    {
        return
            new LegacySpinnerAttacher($this->loop);
    }
}
