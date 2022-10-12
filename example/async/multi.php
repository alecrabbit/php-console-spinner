<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\MultiSpinnerFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;

require_once __DIR__ . '/../bootstrap.php';

$stdout = new StreamOutput(STDOUT);
$echo = $stdout->writeln(...);

$config =
    (new ConfigBuilder())
        ->withCursor()
        ->withInterval(new Interval(100))
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
        ->withTrailingSpacer(CharFrame::createSpace())
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

$spinner = MultiSpinnerFactory::create($config);

$contextOne = $spinner->add($twirlerOne);
$contextTwo = $spinner->add($twirlerTwo);
$contextThree = $spinner->add($twirlerThree);
$contextFour = $spinner->add($twirlerFour);

$spinner->initialize();

$echo('Starting...');

$loop = $config->getLoop();

$loop->periodic(
    $spinner->getInterval()->toSeconds(),
    static function () use ($spinner) {
        $spinner->spin();
    }
);

$loop->defer(10, static function () use ($echo, $spinner, $loop) {
    $echo('Stopping...');
    $spinner->finalize();
    $loop->stop();
});


