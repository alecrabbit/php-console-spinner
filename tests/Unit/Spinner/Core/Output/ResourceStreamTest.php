<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Output\DriverOutput;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ResourceStreamTest extends TestCase
{
    #[Test]
    public function throwsIfStreamIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument is expected to be a stream(resource), "string" given.');

        $result = new ResourceStream('invalid');
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $stream = fopen('php://memory', 'rb+');

        $result = new ResourceStream($stream);

        self::assertInstanceOf(ResourceStream::class, $result);

        fclose($stream);
    }
}
