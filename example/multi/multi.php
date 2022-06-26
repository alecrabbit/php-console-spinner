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
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;
use AlecRabbit\Spinner\Core\WidthDefiner;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->inSynchronousMode()
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
        ->build()
;

$twirlerFour =
    $twirlerBuilder
        ->withStylePattern(StylePattern::rainbow())
        ->withCharPattern(CharPattern::SNAKE_VARIANT_1)
        ->build()
;

$spinner = SpinnerFactory::createMulti($config);

$contextOne = $spinner->add($twirlerOne);
$contextTwo = $spinner->add($twirlerTwo);
$contextThree = $spinner->add($twirlerThree);
$contextFour = $spinner->add($twirlerFour);

$t = [];

dump($spinner);

$interval = (int)$spinner->getInterval()->toMicroseconds();

dump($spinner);

$spinner->initialize();

$max = 2000;
$contextToRemove = null;
for ($i = 0; $i < $max; $i++) {
    $start = hrtime(true);
    $spinner->spin();
    $t[] = hrtime(true) - $start;
    usleep($interval);
//    usleep(random_int(0, $interval * 4));
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
        $tempTwirler = $twirlerBuilder
            ->withStylePattern(StylePattern::red())
            ->withCharPattern(
                [
                    C::FRAMES => ['Another message...'],
                ]
            )
            ->build()
        ;
        $contextToRemove = $spinner->add($tempTwirler);
    }
    if (100 === $i && $contextToRemove instanceof ITwirlerContext) {
        $spinner->remove($contextToRemove);
    }
    if (0 === $i % 5 && $i > 80) {
        $contextFour
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
    }
    if (50 === $i) {
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
    if (80 === $i) {
        $contextOne->setTwirler($contextFour->getTwirler());
    }

    if ($i > 100 && $i % 100 === 0) {
        dump($spinner);
    }
    if ($i > 10 && $i % 20 === 0) {
        $spinner->wrap(
            $echo,
            sprintf(
                '%s %s %s ',
                '(Message to stdout)',
                (new DateTimeImmutable())->format(DATE_ATOM),
                sprintf(
                    'Average: %sμs Real Usage: %sK Peak: %sK',
                    number_format((array_sum($t) / count($t)) / 1000, 3),
                    number_format(memory_get_usage(true) / 1024,),
                    number_format(memory_get_peak_usage(true) / 1024,),
                ),
            )
        );
    }
}

$spinner->finalize();

