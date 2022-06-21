<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Collection\Factory\CharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\StyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Frame\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Core\Frame\Factory\StyleFrameFactory;
use AlecRabbit\Spinner\Core\Revolver\Factory\CharRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Factory\StyleRevolverFactory;
use AlecRabbit\Spinner\Core\SpinnerFactory;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Core\StyleProvider;
use AlecRabbit\Spinner\Core\Twirler\Factory\TwirlerFactory;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;

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

$twirlerOne = $twirlerFactory->create();
$twirlerTwo = $twirlerFactory->create();

$spinner
    ->addTwirler($twirlerOne)
    ->addTwirler($twirlerTwo)
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
