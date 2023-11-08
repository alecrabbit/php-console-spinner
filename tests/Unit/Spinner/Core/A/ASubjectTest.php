<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\A\Override\ASubjectOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ASubjectTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $subject = $this->getTesteeInstance();

        self::assertInstanceOf(ASubject::class, $subject);
    }

    protected function getTesteeInstance(
        ?IObserver $observer = null,
    ): ISubject {
        return new ASubjectOverride(
            observer: $observer,
        );
    }

    #[Test]
    public function canTriggerObserverUpdateOnNotifyCall(): void
    {
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::once())
            ->method('update')
        ;

        $subject = $this->getTesteeInstance(
            observer: $observer,
        );
        $subject->notify();
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function canAttachObserver(): void
    {
        $subject = $this->getTesteeInstance();

        $observer = $this->getObserverMock();

        self::assertNull(self::getPropertyValue('observer', $subject));

        $subject->attach($observer);

        self::assertSame($observer, self::getPropertyValue('observer', $subject));
    }

    #[Test]
    public function canDetachObserver(): void
    {
        $observer = $this->getObserverMock();

        $subject = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue('observer', $subject));

        $subject->detach($observer);

        self::assertNull(self::getPropertyValue('observer', $subject));
    }

    #[Test]
    public function detachesOnlyIfCorrectObserverGiven(): void
    {
        $otherObserver = $this->getObserverMock();
        $observer = $this->getObserverMock();

        $subject = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue('observer', $subject));

        $subject->detach($otherObserver);

        self::assertSame($observer, self::getPropertyValue('observer', $subject));
    }

    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Observer is already attached.';

        $test = function (): void {
            $observer = $this->getObserverMock();
            $subject = $this->getTesteeInstance(
                observer: $observer
            );
            $subject->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
