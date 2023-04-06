<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerAttacherFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\SpinnerAttacher;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerAttacherFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerAttacherFactory::class, $spinnerAttacherFactory);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): ISpinnerAttacherFactory {
        return
            new SpinnerAttacherFactory(
                loop: $loop ?? $this->getLoopMock(),
            );
    }


    #[Test]
    public function canGetAttacher(): void
    {
        $spinnerAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerAttacherFactory::class, $spinnerAttacherFactory);
        self::assertInstanceOf(SpinnerAttacher::class, $spinnerAttacherFactory->getAttacher());
    }
}
