<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Factory\LegacySpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\LegacySpinnerAttacher;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerAttacherFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySpinnerAttacherFactory::class, $spinnerAttacherFactory);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): ILegacySpinnerAttacherFactory {
        return
            new LegacySpinnerAttacherFactory(
                loop: $loop ?? $this->getLoopMock(),
            );
    }


    #[Test]
    public function canGetAttacher(): void
    {
        $spinnerAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySpinnerAttacherFactory::class, $spinnerAttacherFactory);
        self::assertInstanceOf(LegacySpinnerAttacher::class, $spinnerAttacherFactory->getAttacher());
    }
}
