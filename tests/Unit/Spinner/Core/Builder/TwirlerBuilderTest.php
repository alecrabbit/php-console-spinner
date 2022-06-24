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
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase;

class TwirlerBuilderTest extends TestCase
{
    public function builderDataProvider(): iterable
    {
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
                    'styleRevolver' => true,
                    'styleRevolverTwo' => true,
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
                    'stylePattern' => true,
                    'stylePatternTwo' => true,
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider builderDataProvider
     */
    public function canBuild(array $expected, array $incoming): void
    {
        $this->setExpectException($expected);

        $args = $incoming[self::ARGUMENTS];

        $builder = self::getBuilder($args);

        $builder = $this->addToBuilder($builder, $args);

        self::assertInstanceOf(ITwirler::class, $builder->build());
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

    private function addToBuilder(ITwirlerBuilder $builder, mixed $args): ITwirlerBuilder
    {
        if ($args['styleRevolver'] ?? false) {
            $builder = $builder->withStyleRevolver(self::getStyleRevolver($args));
        }
        if ($args['styleRevolverTwo'] ?? false) {
            $builder = $builder->withStyleRevolver(self::getStyleRevolver($args));
        }
        if ($args['stylePattern'] ?? false) {
            $builder = $builder->withStylePattern(StylePattern::none());
        }
        if ($args['stylePatternTwo'] ?? false) {
            $builder = $builder->withStylePattern(StylePattern::none());
        }
        return $builder;
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
}
