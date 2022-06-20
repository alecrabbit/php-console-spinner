<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Kernel;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Style;
use AlecRabbit\Spinner\Kernel\WStyleCollection;
use AlecRabbit\Tests\Spinner\TestCase;

use const AlecRabbit\Cli\CSI;
use const AlecRabbit\Cli\RESET;

class StyleCollectionTest extends TestCase
{
    protected const STYLE = CSI . '01;38;5;45m%s' . RESET;

    public function createDataProvider(): iterable
    {
        // [$expected, $styles, $interval]
        yield [
            [
                self::COUNT => 1,
                self::INTERVAL => (float)Defaults::MILLISECONDS_INTERVAL / 1000,
                self::CONTAINS => [
                    Style::create('%s'),
                ],
            ],
            [],
            null
        ];

        yield [
            [
                self::COUNT => 1,
                self::INTERVAL => 1.0,
                self::CONTAINS => [
                    Style::create('%s'),
                ],
            ],
            ['%s'],
            1000
        ];

        yield [
            [
                self::COUNT => 2,
                self::INTERVAL => 0.1,
                self::CONTAINS => [
                    Style::create('%s'),
                    Style::create(self::STYLE),
                ],
            ],
            [
                '%s',
                self::STYLE,
            ],
            100
        ];

        yield [
            [
                self::COUNT => 3,
                self::INTERVAL => 0.222,
                self::CONTAINS => [
                    Style::create('%s'),
                    Style::create('>%s<'),
                    Style::create(self::STYLE),
                ],
            ],
            [
                '%s',
                '>%s<',
                self::STYLE,
            ],
            222
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Interval should be greater than %s.',
                            Defaults::MILLISECONDS_MIN_INTERVAL
                        ),
                ],
            ],
            ['%s'],
            -1
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE =>
                        sprintf(
                            'Interval should be less than %s.',
                            Defaults::MILLISECONDS_MAX_INTERVAL
                        ),
                ],
            ],
            ['%s'],
            Defaults::MILLISECONDS_MAX_INTERVAL + 1000
        ];
    }

    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(array $expected, array $styles, ?int $interval = null): void
    {
        $this->setExpectException($expected);

        $styleCollection = WStyleCollection::create($styles, $interval);

        self::assertCount($expected[self::COUNT], $styleCollection);
        self::assertEquals($expected[self::INTERVAL], $styleCollection->getInterval()->toSeconds());
        self::assertSame($expected[self::INTERVAL], $styleCollection->getInterval()->toSeconds());

        foreach ($expected[self::CONTAINS] as $c) {
            self::assertContainsEquals($c, $styleCollection);
        }

        $a = $styleCollection->toArray();
        foreach ($expected[self::CONTAINS] as $c) {
            self::assertContainsEquals($c, $a);
        }
    }
}
