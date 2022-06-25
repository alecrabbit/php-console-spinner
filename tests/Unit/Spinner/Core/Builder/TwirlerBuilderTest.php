<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Revolver\CharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\StyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Builder\TwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Twirler;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\Spinner\TestCase;

class TwirlerBuilderTest extends TestCase
{
    final protected const NO_LEADING_SPACER = 'noLeadingSpacer';
    final protected const NO_TRAILING_SPACER = 'noTrailingSpacer';
    final protected const LEADING_SPACER = 'leadingSpacer';
    final protected const TRAILING_SPACER = 'trailingSpacer';

    public function builderDataProvider(): iterable
    {
        $index = 0;
        // [$expected, $incoming]
        // #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style revolver is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getStyleRevolver(),
                        self::getStyleRevolver(),
                    ],
                ],
            ],
        ];

        // #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char revolver is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getCharRevolver(),
                        self::getCharRevolver(),
                    ],
                ],
            ],
        ];

        // #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style pattern is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::STYLE_PATTERN . ++$index => StylePattern::none(),
                        self::STYLE_PATTERN . ++$index => StylePattern::none(),
                    ],
                ],
            ],
        ];

        // #3
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char pattern is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::CHAR_PATTERN . ++$index => CharPattern::none(),
                        self::CHAR_PATTERN . ++$index => CharPattern::none(),
                    ],
                ],
            ],
        ];

        // #4
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style revolver is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getStyleRevolver(),
                        self::STYLE_PATTERN . ++$index => StylePattern::none(),
                    ],
                ],
            ],
        ];

        // #5
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char revolver is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getCharRevolver(),
                        self::CHAR_PATTERN . ++$index => CharPattern::none(),
                    ],
                ],
            ],
        ];

        // #6
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style frame collection factory is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getStyleFrameCollection(),
                        self::getStyleFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #7
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char frame collection factory is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getCharFrameCollection(),
                        self::getCharFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #8
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style frame collection is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getStyleFrameCollection(),
                        self::getStyleRevolver(),
                    ],
                ],
            ],
        ];

        // #9
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char frame collection is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getCharFrameCollection(),
                        self::getCharRevolver(),
                    ],
                ],
            ],
        ];

        // #10
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style frame collection factory is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getStyleFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #11
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char frame collection factory is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::WITH => [
                        self::getCharFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #12
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style frame collection factory is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => self::getBuilder(null),
                    self::WITH => [
                        self::getStyleFrameCollectionFactory(),
                        self::getCharFrameCollectionFactory(),
                        self::getStyleFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #13
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char frame collection factory is already set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => self::getBuilder(null),
                    self::WITH => [
                        self::getStyleFrameCollectionFactory(),
                        self::getCharFrameCollectionFactory(),
                        self::getCharFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #14
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Style frame collection factory is not set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => self::getBuilder(null),
                    self::WITH => [
                        self::getCharFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        // #15
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => DomainException::class,
                    self::MESSAGE => 'Char frame collection factory is not set.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => self::getBuilder(null),
                    self::WITH => [
                        self::getStyleFrameCollectionFactory(),
                    ],
                ],
            ],
        ];

        yield [
            [
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => self::getBuilder(null),
                    self::WITH => [
                        self::getStyleFrameCollectionFactory(),
                        self::getCharFrameCollectionFactory(),
                        self::TRAILING_SPACER => CharFrame::createEmpty(),
                        self::NO_TRAILING_SPACER => true,
                    ],
                ],
            ],
        ];

        yield [
            [
            ],
            [
                self::ARGUMENTS => [
                    self::BUILDER => self::getBuilder(null),
                    self::WITH => [
                        self::getStyleFrameCollectionFactory(),
                        self::getCharFrameCollectionFactory(),
                        self::LEADING_SPACER => CharFrame::createEmpty(),
                        self::NO_LEADING_SPACER => true,
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

    private static function getCharRevolver(array $args = []): ICharRevolver
    {
        return
            new CharRevolver(
                self::getCharFrameCollection($args)
            );
    }

    private static function getCharFrameCollection(array $args = []): ICharFrameCollection
    {
        return
            CharFrameCollection::create(
                [CharFrame::createEmpty()],
                new Interval(null)
            );
    }

    protected static function getStyleFrameCollectionFactory(): IStyleFrameCollectionFactory
    {
        return new class implements IStyleFrameCollectionFactory {
            public function create(?array $stylePattern = null): IStyleFrameCollection
            {
                return StyleFrameCollection::create(
                    [StyleFrame::createEmpty()],
                    new Interval(null),
                );
            }
        };
    }

    protected static function getCharFrameCollectionFactory(): ICharFrameCollectionFactory
    {
        return new class implements ICharFrameCollectionFactory {
            public function create(?array $charPattern = null): ICharFrameCollection
            {
                return CharFrameCollection::create(
                    [CharFrame::createEmpty()],
                    new Interval(null),
                );
            }
        };
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

        $twirler = $builder->build();

        self::assertInstanceOf(Twirler::class, $twirler);
    }

    private function prepareBuilder(array $args = []): ITwirlerBuilder
    {
        $builder = self::extractBuilder($args);

        $with = $args[self::WITH] ?? [];

        foreach ($with as $key => $item) {
            if ($item instanceof IStyleRevolver) {
                $builder = $builder->withStyleRevolver($item);
            }
            if ($item instanceof ICharRevolver) {
                $builder = $builder->withCharRevolver($item);
            }
            if ($item instanceof IStyleFrameCollection) {
                $builder = $builder->withStyleCollection($item);
            }
            if ($item instanceof ICharFrameCollection) {
                $builder = $builder->withCharCollection($item);
            }
            if ($item instanceof IStyleFrameCollectionFactory) {
                $builder = $builder->withStyleFrameCollectionFactory($item);
            }
            if ($item instanceof ICharFrameCollectionFactory) {
                $builder = $builder->withCharFrameCollectionFactory($item);
            }
            if (\is_string($key) && \str_contains($key, self::STYLE_PATTERN)) {
                $builder = $builder->withStylePattern($item);
            }
            if (\is_string($key) && \str_contains($key, self::CHAR_PATTERN)) {
                $builder = $builder->withCharPattern($item);
            }
            /** @noinspection NotOptimalIfConditionsInspection */
            if (\is_string($key) && \str_contains($key, self::NO_LEADING_SPACER) && $item === true) {
                $builder = $builder->noLeadingSpacer();
            }
            /** @noinspection NotOptimalIfConditionsInspection */
            if (\is_string($key) && \str_contains($key, self::NO_TRAILING_SPACER) && $item === true) {
                $builder = $builder->noTrailingSpacer();
            }

            if ($item instanceof ICharFrame && \is_string($key) && \str_contains($key, self::LEADING_SPACER)) {
                $builder = $builder->withLeadingSpacer($item);
            }

            if ($item instanceof ICharFrame && \is_string($key) && \str_contains($key, self::TRAILING_SPACER)) {
                $builder = $builder->withTrailingSpacer($item);
            }

        }

        return $builder;
    }

    public static function getBuilder(?array $args = []): ITwirlerBuilder
    {
        if (null === $args) {
            return
                new TwirlerBuilder();
        }
        $config = self::getDefaultConfig();
        return
            new TwirlerBuilder(
                $config->getStyleFrameCollectionFactory(),
                $config->getCharFrameCollectionFactory(),
            );
    }

    private static function extractBuilder(array $args): mixed
    {
        return $args[self::BUILDER] ?? self::getBuilder($args);
    }
}
