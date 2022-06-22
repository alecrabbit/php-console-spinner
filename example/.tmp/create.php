<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\SpinnerFactory;
use AlecRabbit\Spinner\Core\Twirler\TwirlerBuilder;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Contract\Base\CharPattern;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;

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

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->build()
;

$spinner = SpinnerFactory::create($config);

$twirlerFactory = $config->getTwirlerFactory();
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
        ->build()
;
$twirlerThree = $twirlerBuilder->build();


$spinner
    ->addTwirler($twirlerOne)
    ->addTwirler($twirlerTwo)
    ->addTwirler($twirlerThree)
;

dump($spinner);

$spinner->initialize();

for ($i = 0; $i < 100; $i++) {
//    $start = hrtime(true);
    $spinner->spin();
//    $stop = hrtime(true);
//    dump($stop - $start);
    usleep(100000);
}

$spinner->finalize();
