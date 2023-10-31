<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
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

        self::assertSame($str, self::extractBufferContents($buffer));
    }

    public function getTesteeInstance(
        ?string $buffer = null,
    ): IBuffer {
        return
            new StringBuffer(
                buffer: $buffer ?? '',
            );
    }

    protected static function extractBufferContents(IBuffer $buffer): mixed
    {
        return self::getPropertyValue('buffer', $buffer);
    }

    #[Test]
    public function appendsToBuffer(): void
    {
        $str = 'new string';
        $buffer = $this->getTesteeInstance();

        self::assertSame('', self::extractBufferContents($buffer));

        $buffer->append($str);

        self::assertSame($str, self::extractBufferContents($buffer));
    }

    #[Test]
    public function flushesBuffer(): void
    {
        $str = 'new string';
        $buffer = $this->getTesteeInstance();

        self::assertSame('', self::extractBufferContents($buffer));

        $buffer->append($str);

        self::assertSame($str, self::extractBufferContents($buffer));

        $content = implode('', iterator_to_array($buffer->flush()));
        self::assertSame($content, $str);

        self::assertSame('', self::extractBufferContents($buffer));
    }
}
