<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\A\Override;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use RuntimeException;

class ObserverASubjectOverride extends ASubjectOverride implements IObserver
{
    public function update(ISubject $subject): void
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
