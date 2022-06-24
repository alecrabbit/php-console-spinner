<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\StyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Builder\TwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Twirler;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase;

class TwirlerBuilderTest extends TestCase
{

    public function builderDataProvider(): iterable
    {
        $index = 0;
        // [$expected, $incoming]
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Style revolver is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => [
                        self::getStyleRevolver(),
                        self::getStyleRevolver(),
                    ],
                ],
            ],
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Style pattern is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => [
                        self::STYLE_PATTERN . ++$index => StylePattern::none(),
                        self::STYLE_PATTERN . ++$index => StylePattern::none(),
                    ],
                ],
            ],
        ];

        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Style revolver is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => [
                        self::getStyleRevolver(),
                        self::STYLE_PATTERN . ++$index => StylePattern::none(),
                    ],
                ],
            ],
        ];
    }

    private static function getStyleRevolver(array $args = []): IStyleRevolver
    {
        return
            new StyleRevolver(
                self::getStyleFrameCollection($args)
            );
    }

    private static function getStyleFrameCollection(array $args = []): IStyleFrameCollection
    {
        return
            StyleFrameCollection::create(
                [StyleFrame::createEmpty()],
                new Interval(null)
            );
    }

    /**
     * @test
     * @dataProvider builderDataProvider
     */
    public function canBuild(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $args = $incoming[self::ARGUMENTS];

        $builder = $this->prepareBuilder($args);

        self::assertInstanceOf(Twirler::class, $builder->build());
    }

    private function prepareBuilder(mixed $args): ITwirlerBuilder
    {
        $builder = self::getBuilder($args);

        foreach ($args[self::BUILDER] ?? [] as $key => $item) {
            if ($item instanceof IStyleRevolver) {
                $builder = $builder->withStyleRevolver($item);
            }
            if (\is_string($key) && \str_contains($key, self::STYLE_PATTERN)) {
                $builder = $builder->withStylePattern($item);
            }
        }

        return $builder;
    }

    public static function getBuilder(array $args = []): ITwirlerBuilder
    {
        $config = self::getDefaultConfig();
        return
            new TwirlerBuilder(
                $config->getStyleFrameCollectionFactory(),
                $config->getCharFrameCollectionFactory(),
            );
    }
}
