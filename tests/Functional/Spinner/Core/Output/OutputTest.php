<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Output;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class OutputTest extends TestCase
{
    #[Test]
    public function canWriteStr(): void
    {
        $str = 'test';

        $buffer = $this->getBuffer();
        $stream = $this->getStreamStub($buffer);

        $output = new Output(stream: $stream);

        $output->write($str);

        self::assertSame($str, $this->unwrapToStr($buffer->flush()));
    }

    protected function getBuffer(): IBuffer
    {
        return new StringBuffer();
    }

    protected function getStreamStub(IBuffer $buffer): IResourceStream
    {
        return
            new class($buffer) implements IResourceStream {
                public function __construct(
                    protected IBuffer $buffer,
                ) {
                }

                public function write(Traversable $data): void
                {
                    foreach ($data as $line) {
                        $this->buffer->append($line);
                    }
                }
            };
    }

    private function unwrapToStr(\Traversable $iterator): string
    {
        return implode('', iterator_to_array($iterator));
    }

    #[Test]
    public function canWriteLnStr(): void
    {
        $str = 'test';

        $buffer = $this->getBuffer();
        $stream = $this->getStreamStub($buffer);

        $output = new Output(stream: $stream);

        $output->writeln($str);

        self::assertSame($str . PHP_EOL, $this->unwrapToStr($buffer->flush()));
    }

    #[Test]
    public function canWriteIterable(): void
    {
        $arg = ['msg1', 'msg2'];

        $buffer = $this->getBuffer();
        $stream = $this->getStreamStub($buffer);

        $output = new Output(stream: $stream);

        $output->write($arg);

        self::assertSame('msg1msg2', $this->unwrapToStr($buffer->flush()));
    }

    #[Test]
    public function canWriteLnIterable(): void
    {
        $arg = ['msg1', 'msg2'];

        $buffer = $this->getBuffer();
        $stream = $this->getStreamStub($buffer);

        $output = new Output(stream: $stream);

        $output->writeln($arg);

        self::assertSame('msg1' . PHP_EOL . 'msg2' . PHP_EOL, $this->unwrapToStr($buffer->flush()));
    }
}
