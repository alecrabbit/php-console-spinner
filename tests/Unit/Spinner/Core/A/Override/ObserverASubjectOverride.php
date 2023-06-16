<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\A\Override;

use AlecRabbit\Spinner\Contract\ISubject;

class ObserverASubjectOverride extends ASubjectOverride implements \AlecRabbit\Spinner\Contract\IObserver
{
    public function update(ISubject $subject): void
    {
        throw new \RuntimeException('INTENTIONALLY Not implemented.');
    }
}
