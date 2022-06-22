<?php

declare(strict_types=1);

// 20.06.22

use AlecRabbit\Spinner\Core\SpinnerFactory;
use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Contract\Base\CharPattern;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Kernel\Output\StreamOutput;

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
        ->withCharCollection(
            $charCollectionFactory->create(
                CharPattern::DOTS_VARIANT_3
            )
        )
        ->build()
;
$twirlerTwo =
    $twirlerBuilder
        ->withStylePattern(StylePattern::rainbow())
        ->withCharPattern(CharPattern::SNAKE_VARIANT_3)
        ->build()
;

$twirlerFour =
    $twirlerBuilder
        ->withStylePattern(StylePattern::rainbow())
        ->withCharPattern(CharPattern::SNAKE_VARIANT_1)
        ->build()
;

$twirlerThree = $twirlerBuilder->build();

$spinner = SpinnerFactory::create($config);

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
    $t[] = hrtime(true) - $start;
    usleep($interval);
    if ($i > 10 && $i % 20 === 0) {
        $spinner->wrap(
            $echo,
            sprintf('Average cycle execution time: %sμs', number_format((array_sum($t) / count($t)) / 1000, 3))
        );
    }
}

$spinner->finalize();

