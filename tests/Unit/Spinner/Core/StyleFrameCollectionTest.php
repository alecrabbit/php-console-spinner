<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;

class StyleFrameCollectionTest extends TestCase
{
    protected const STYLE = CSI . '01;38;5;45m%s' . RESET;

    public function createDataProvider(): iterable
    {
        $frame = StyleFrame::createEmpty();
        // [$expected, $frames, $interval]
        yield [
            [
                self::COUNT => 1,
                self::INTERVAL => (float)Defaults::getMaxIntervalMilliseconds() / 1000,
                self::CONTAINS => [
                    $frame
                ],
            ],
            [$frame],
            Interval::createDefault(),
        ];

        yield [
            [
                self::COUNT => 1,
                self::INTERVAL => 1.0,
                self::CONTAINS => [
                    $frame
                ],
            ],
            [$frame],
            new Interval(1000)
        ];

        yield [
            [
                self::COUNT => 2,
                self::INTERVAL => 0.1,
                self::CONTAINS => [
                    new StyleFrame('>', '<'),
                    $frame,
                ],
            ],
            [
                new StyleFrame('>', '<'),
                $frame,
            ],
            new Interval(100)
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            '%s: Collection is empty.',
                            StyleFrameCollection::class
                        ),
                ],
            ],
            [],
            new Interval(100)
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Element must be instance of "%s".',
                            IStyleFrame::class
                        ),
                ],
            ],
            [1],
            new Interval(100)
        ];

//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE =>
//                        sprintf(
//                            'Interval should be less than %s.',
//                            Defaults::MILLISECONDS_MAX_INTERVAL
//                        ),
//                ],
//            ],
//            ['%s'],
//            Defaults::MILLISECONDS_MAX_INTERVAL + 1000
//        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $frames, IInterval $interval): void
    {
        $this->setExpectException($expected);

        $styleCollection = StyleFrameCollection::create($frames, $interval);

        self::assertCount($expected[self::COUNT], $styleCollection);
        self::assertEquals($expected[self::INTERVAL], $styleCollection->getInterval()->toSeconds());
        self::assertSame($expected[self::INTERVAL], $styleCollection->getInterval()->toSeconds());

        foreach ($expected[self::CONTAINS] as $c) {
            self::assertContainsEquals($c, $styleCollection);
        }

        $a = iterator_to_array($styleCollection->getIterator());
        foreach ($expected[self::CONTAINS] as $c) {
            self::assertContainsEquals($c, $a);
        }
    }
}
