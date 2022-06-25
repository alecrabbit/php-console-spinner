<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Core\SpinnerFactory;
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

dump($spinner);

$t = [];

$interval = (int)$spinner->getInterval()->toMicroseconds();

$spinner->initialize();

//dump($spinner);

for ($i = 0; $i < 200; $i++) {
    $start = hrtime(true);
    $spinner->spin();
    $t[] = hrtime(true) - $start;
    usleep($interval);
    if ($i > 10 && $i % 20 === 0) {
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

