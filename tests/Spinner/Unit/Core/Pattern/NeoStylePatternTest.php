<?php

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;
use AlecRabbit\Spinner\Core\Pattern\NeoStylePattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NeoStylePatternTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(NeoStylePattern::class, $factory);
    }

    public function getTesteeInstance(
        ?IHasFrame $frames = null,
        ?IInterval $interval = null,
        ?IStyleFrameTransformer $transformer = null,
    ): INeoStylePattern {
        return new NeoStylePattern(
            frames: $frames ?? $this->getHasFrameMock(),
            interval: $interval ?? $this->getIntervalMock(),
            transformer: $transformer ?? $this->getStyleFrameTransformerMock(),
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

    private function getStyleFrameTransformerMock(): MockObject&IStyleFrameTransformer
    {
        return $this->createMock(IStyleFrameTransformer::class);
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

        $frame01 = $this->getStyleSequenceFrameMock();
        $frame02 = $this->getStyleSequenceFrameMock();
        $frame03 = $this->getStyleSequenceFrameMock();

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

        $transformer = $this->getStyleFrameTransformerMock();

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

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }
}
