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
use AlecRabbit\Spinner\Core\Twirler\Factory\TwirlerFactory;
use AlecRabbit\Spinner\Core\Twirler\TwirlerContainer;

require_once __DIR__ . '/../bootstrap.php';

//$stylePatternExtractor = new StylePatternExtractor();
//
//$container = new TwirlerContainer();
//
$twirlerFactory = new TwirlerFactory(
    new StyleRevolverFactory(
        new StyleFrameCollectionFactory(
            new StyleFrameFactory()
        ),
    ),
    new CharRevolverFactory(
        new CharFrameCollectionFactory(
            new CharFrameFactory()
        ),
    ),
);

$twirler = $twirlerFactory->create();
//
//$container->addTwirler($twirler);
//
//dump($container);

$spinner = SpinnerFactory::create();

$spinner->addTwirler($twirler);

//dump($spinner);

$spinner->initialize();

$spinner->spin();

$spinner->spin();

$spinner->finalize();
