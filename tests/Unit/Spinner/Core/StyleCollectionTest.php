<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Style;
use AlecRabbit\Spinner\Core\StyleCollection;
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
                self::INTERVAL => Defaults::MILLISECONDS_INTERVAL / 1000,
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
                    self::_CLASS => InvalidArgumentException::class,
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
                    self::_CLASS => InvalidArgumentException::class,
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
        if (array_key_exists(self::EXCEPTION, $expected)) {
            $this->expectException($expected[self::EXCEPTION][self::_CLASS]);
            $this->expectExceptionMessage($expected[self::EXCEPTION][self::MESSAGE]);
        }

        $styleCollection = StyleCollection::create($styles, $interval);

        self::assertCount($expected[self::COUNT], $styleCollection);
        self::assertEquals($expected[self::INTERVAL], $styleCollection->getInterval()->toSeconds());
        self::assertSame($expected[self::INTERVAL], $styleCollection->getInterval()->toSeconds());

        foreach ($expected[self::CONTAINS] as $c) {
            self::assertContainsEquals($c, $styleCollection);
        }
    }
}
