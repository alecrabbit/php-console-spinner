<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Output\Contract\IStringBuffer;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class StringBufferTest extends TestCase
{
    #[Test]
    public function isCreatedWithGivenBuffer(): void
    {
        $str = 'test';
        $buffer = $this->getTesteeInstance(buffer: $str);

        self::assertSame($str, self::getPropertyValue('buffer', $buffer));
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

        self::assertSame('', self::getPropertyValue('buffer', $buffer));

        $buffer->write($str);

        self::assertSame($str, self::getPropertyValue('buffer', $buffer));
    }

    #[Test]
    public function flushesBuffer(): void
    {
        $str = 'new string';
        $buffer = $this->getTesteeInstance();

        self::assertSame('', self::getPropertyValue('buffer', $buffer));

        $buffer->write($str);

        self::assertSame($str, self::getPropertyValue('buffer', $buffer));

        $content = implode('', iterator_to_array($buffer->flush()));
        self::assertSame($content, $str);

        self::assertSame('', self::getPropertyValue('buffer', $buffer));
    }
}
