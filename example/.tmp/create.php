<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\SpinnerFactory;
use AlecRabbit\Spinner\Core\Twirler\TwirlerBuilder;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Contract\Base\CharPattern;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Kernel\Output\StreamOutput;

require_once __DIR__ . '/../bootstrap.php';

//$stylePatternExtractor = new StylePatternExtractor();
//
//$container = new TwirlerContainer();
//
//$twirlerFactory = new TwirlerFactory(
//    new StyleRevolverFactory(
//        new StyleFrameCollectionFactory(
//            new StyleFrameFactory(),
//            new StyleProvider(
//                $stylePatternExtractor
//            )
//        ),
//    ),
//    new CharRevolverFactory(
//        new CharFrameCollectionFactory(
//            new CharFrameFactory()
//        ),
//    ),
//);
//
//$twirlerOne = $twirlerFactory->create();
//$twirlerTwo = $twirlerFactory->create();
//
//$container->addTwirler($twirler);
//
//dump($container);

$stdout = new StreamOutput(STDOUT);

$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->build()
;

$spinner = SpinnerFactory::create($config);

$styleCollectionFactory = $config->getStyleFrameCollectionFactory();
$charCollectionFactory = $config->getCharFrameCollectionFactory();

$twirlerBuilder = $config->getTwirlerBuilder();

$twirlerOne =
    $twirlerBuilder
        ->withCharCollection(
            $charCollectionFactory->create(
                CharPattern::DOTS_VARIANT_3
            )
        )
        ->build()
;
$twirlerTwo =
    $twirlerBuilder
        ->withStyleCollection(
            $styleCollectionFactory->create(
                StylePattern::rainbow()
            )
        )
        ->withCharCollection(
            $charCollectionFactory->create(
                CharPattern::SNAKE_VARIANT_1
            )
        )
        ->build()
;

$twirlerFour =
    $twirlerBuilder
        ->withStyleCollection(
            $styleCollectionFactory->create(
                StylePattern::rainbow()
            )
        )
        ->withCharCollection(
            $charCollectionFactory->create(
                CharPattern::SNAKE_VARIANT_1
            )
        )
        ->build()
;

$twirlerThree = $twirlerBuilder->build();


$spinner
    ->addTwirler($twirlerThree)
    ->addTwirler($twirlerFour)
    ->addTwirler($twirlerOne)
    ->addTwirler($twirlerTwo)
;

dump($spinner);

$spinner->initialize();

$t = [];

//$interval = $spinner->getInterval()->toMicroseconds();
$interval = 100000;
for ($i = 0; $i < 200; $i++) {
    $start = hrtime(true);
    $spinner->spin();
    $t[]= hrtime(true) - $start;
    usleep($interval);
    if($i > 10 && $i % 20 === 0) {
        $spinner->wrap($echo, sprintf('Average cycle execution time: %sμs', number_format((array_sum($t) / count($t)) / 1000, 3)));
    }

}

$spinner->finalize();

