<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\A;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\Spinner\Unit\Core\A\Override\ObserverASubjectOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ObserverASubjectTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $subject = $this->getTesteeInstance();

        self::assertInstanceOf(ASubject::class, $subject);
    }

    protected function getTesteeInstance(
        ?IObserver $observer = null,
    ): ISubject&IObserver {
        return new ObserverASubjectOverride(
            observer: $observer,
        );
    }

    #[Test]
    public function throwsIfObserverAttachedIsSelf(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $observerAndSubject = $this->getTesteeInstance();
            $observerAndSubject->attach($observerAndSubject);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
