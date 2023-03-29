<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IBufferedOutput;
use AlecRabbit\Spinner\Contract\IResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StreamBufferedOutputTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $streamBufferedOutput = $this->getTesteeInstance(stream: null);

        self::assertInstanceOf(StreamBufferedOutput::class, $streamBufferedOutput);
    }

    public function getTesteeInstance(
        (MockObject&IResourceStream)|null $stream,
        ?StringBuffer $buffer = null,
    ): IBufferedOutput {
        if (null === $buffer) {
            return
                new StreamBufferedOutput(
                    stream: $stream ?? $this->getStreamMock(),
                );
        }
        return
            new StreamBufferedOutput(
                stream: $stream ?? $this->getStreamMock(),
                buffer: $buffer
            );
    }

    private function getStreamMock(): MockObject&IResourceStream
    {
        return $this->createMock(IResourceStream::class);
    }

    #[Test]
    public function callingWriteInvokesStreamWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write');

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->write('test');
    }

    #[Test]
    public function callingWritelnInvokesStreamWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write');

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->writeln('test');
    }

    #[Test]
    public function canWriteTraversable(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write');

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->writeln(['test', 'test2']);
    }

    #[Test]
    public function canDoIterableBufferedWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write');

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->bufferedWrite(['test', 'test2'])->flush();
    }
//
//    #[Test]
//    public function canBuildSpinnerWithNoConfigProvided(): void
//    {
//        $container = $this->createMock(IContainer::class);
//        $container
//            ->method('get')
//            ->willReturn(
//                $this->createMock(IConfigBuilder::class),
//                $this->createMock(IDriverBuilder::class),
//                $this->createMock(IWidgetBuilder::class),
//            )
//        ;
//
//        $spinnerBuilder = $this->getTesteeInstance(container: $container);
//
//        $spinner = $spinnerBuilder->build();
//
//        self::assertInstanceOf(SpinnerBuilder::class, $spinnerBuilder);
//        self::assertInstanceOf(ASpinner::class, $spinner);
//        self::assertInstanceOf(IConfig::class, self::getValue('config', $spinnerBuilder));
//    }
//
//    protected function getContainerMock(): MockObject&IContainer
//    {
//        return $this->createMock(IContainer::class);
//    }
}
