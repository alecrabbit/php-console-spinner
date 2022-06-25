<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\SpinnerFactory;
use AlecRabbit\Spinner\Core\WidthDefiner;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->build()
;

$styleCollectionFactory = $config->getStyleFrameCollectionFactory();
$charCollectionFactory = $config->getCharFrameCollectionFactory();

$twirlerBuilder = $config->getTwirlerBuilder();

$twirlerOne =
    $twirlerBuilder
        ->withLeadingSpacer(CharFrame::createSpace())
        ->noTrailingSpacer()
        ->withCharCollection(
            $charCollectionFactory->create(
                CharPattern::DOTS_VARIANT_3
            )
        )
        ->build()
;

$twirlerTwo =
    $twirlerBuilder
        ->withStylePattern(StylePattern::rainbowBg())
        ->withCharPattern(CharPattern::SNAKE_VARIANT_3)
        ->withLeadingSpacer(CharFrame::createSpace())
        ->withTrailingSpacer(CharFrame::createSpace())
        ->build()
;

$twirlerThree =
    $twirlerBuilder
//        ->withStylePattern(StylePattern::none())
//        ->withCharPattern(CharPattern::SNAKE_VARIANT_0)
        ->build()
;

$twirlerFour =
    $twirlerBuilder
        ->withStylePattern(StylePattern::rainbow())
        ->withCharPattern(CharPattern::SNAKE_VARIANT_1)
        ->build()
;

$spinner = SpinnerFactory::createMulti($config);
//dump($spinner->getInterval());

$contextOne = $spinner->add($twirlerOne);
$contextTwo = $spinner->add($twirlerTwo);
$contextThree = $spinner->add($twirlerThree);
$contextFour = $spinner->add($twirlerFour);

$t = [];

$interval = (int)$spinner->getInterval()->toMicroseconds();

//dump($spinner);

$spinner->initialize();

dump($spinner);

$max = 200;
for ($i = 0; $i < $max; $i++) {
    $start = hrtime(true);
    $spinner->spin();
    $t[] = hrtime(true) - $start;
    usleep($interval);
    if (40 === $i) {
        $spinner->pause();
    }
    if (50 === $i) {
        $spinner->resume();
    }
    if (55 === $i) {
        $spinner->add(
            $twirlerBuilder
                ->withCharCollection(
                    CharFrameCollection::create(
                        [
                            CharFrame::create(
                                $m = 'Message...',
                                WidthDefiner::define($m)
                            ),
                        ],
                        new Interval(null)
                    )
                )
                ->build()
        );
        $spinner->add(
            $twirlerBuilder
                ->withCharPattern(
                    [
                        C::FRAMES => ['Message...'],
                        C::ELEMENT_WIDTH => 10,
                    ]
                )
                ->build()
        );
    }
    if (0 === $i % 5 && $i > 80) {
        $contextOne
            ->setTwirler(
                $twirlerBuilder
                    ->withCharCollection(
                        CharFrameCollection::create(
                            [
                                CharFrame::create(
                                    $m = sprintf('%s%%', (int)(($i * 100) / $max)),
                                    WidthDefiner::define($m)
                                ),
                            ],
                            new Interval(null)
                        )
                    )
                    ->build()
            )
        ;
        $contextThree
            ->setTwirler(
                $twirlerBuilder
                    ->withLeadingSpacer(CharFrame::createSpace())
                    ->withCharCollection(
                        $charCollectionFactory->create(
                            CharPattern::DOTS_VARIANT_3
                        )
                    )
                    ->build()
            )
        ;
    }

    if ($i > 10 && $i % 20 === 0) {
        $spinner->wrap(
            $echo,
            sprintf(
                '%s %s %s ',
                '(Message to stdout)',
                (new DateTimeImmutable())->format(DATE_ATOM),
                sprintf('Real Usage: %sK', number_format(memory_get_usage(true) / 1024,)),
            )
        );
        $spinner->wrap(
            $echo,
            sprintf(
                'Average cycle execution time: %sμs',
                number_format((array_sum($t) / count($t)) / 1000, 3)
            )
        );
    }
}

$spinner->finalize();

