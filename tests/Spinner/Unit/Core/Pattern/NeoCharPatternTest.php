<?php

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\INeoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\NeoCharPattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NeoCharPatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(NeoCharPattern::class, $factory);
    }

    public function getTesteeInstance(
        ?IHasFrame $frames = null,
        ?IInterval $interval = null,
        ?ICharFrameTransformer $transformer = null,
    ): INeoCharPattern {
        return new NeoCharPattern(
            frames: $frames ?? $this->getHasFrameMock(),
            interval: $interval ?? $this->getIntervalMock(),
            transformer: $transformer ?? $this->getCharFrameTransformerMock(),
        );
    }

    private function getHasFrameMock(): MockObject&IHasFrame
    {
        return $this->createMock(IHasFrame::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getCharFrameTransformerMock(): MockObject&ICharFrameTransformer
    {
        return $this->createMock(ICharFrameTransformer::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $factory = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $factory->getInterval());
    }

    #[Test]
    public function canGetFrames(): void
    {
        $f01 = $this->getFrameMock();
        $f02 = $this->getFrameMock();
        $f03 = $this->getFrameMock();

        $frame01 = $this->getCharSequenceFrameMock();
        $frame02 = $this->getCharSequenceFrameMock();
        $frame03 = $this->getCharSequenceFrameMock();

        $frames = $this->getHasFrameMock();
        $frames
            ->expects(self::exactly(3))
            ->method('getFrame')
            ->willReturnOnConsecutiveCalls(
                $f01,
                $f02,
                $f03,
            )
        ;

        $transformer = $this->getCharFrameTransformerMock();

        {
            // A workaround to absence of `->withConsecutive()` method in PHPUnit 10
            // input:
            $mock = $transformer;
            $method = 'transform';
            $repetitions = 3;
            $dataSet = new \ArrayObject(
                [
                    $frame01,
                    $frame02,
                    $frame03,
                ]
            );

            $matcher = self::exactly($repetitions);

            $mock
                ->expects($matcher)
                ->method($method)
                ->willReturnCallback(
                    function () use ($matcher, $dataSet) {
                        $index = ($matcher->numberOfInvocations() - 1) % $dataSet->count();
                        return $dataSet->offsetGet($index);
                    }
                )
            ;
        }


        $factory = $this->getTesteeInstance(
            frames: $frames,
            transformer: $transformer,
        );

        self::assertSame($frame01, $factory->getFrame());
        self::assertSame($frame02, $factory->getFrame());
        self::assertSame($frame03, $factory->getFrame());
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    private function getCharSequenceFrameMock(): MockObject&ICharSequenceFrame
    {
        return $this->createMock(ICharSequenceFrame::class);
    }
}
