<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Contract\IStringBuffer;
use AlecRabbit\Spinner\Core\Output\Cursor;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StringBufferTest extends TestCase
{
    #[Test]
    public function isCreatedWithGivenBuffer(): void
    {
        $str = 'test';
        $buffer = $this->getTesteeInstance(buffer: $str);

        self::assertSame($str, self::getValue('buffer', $buffer));
    }

    public function getTesteeInstance(
        ?string $buffer = null,
    ): IStringBuffer {
        return
            new StringBuffer(
                buffer: $buffer ?? '',
            );
    }

    #[Test]
    public function writesToBuffer(): void
    {
        $str = 'new string';
        $buffer = $this->getTesteeInstance();

        self::assertSame('', self::getValue('buffer', $buffer));

        $buffer->write($str);

        self::assertSame($str, self::getValue('buffer', $buffer));
    }

    #[Test]
    public function flushesBuffer(): void
    {
        $str = 'new string';
        $buffer = $this->getTesteeInstance();

        self::assertSame('', self::getValue('buffer', $buffer));

        $buffer->write($str);

        self::assertSame($str, self::getValue('buffer', $buffer));

        $content = implode('', iterator_to_array($buffer->flush()));
        self::assertSame($content, $str);

        self::assertSame('', self::getValue('buffer', $buffer));
    }
}
