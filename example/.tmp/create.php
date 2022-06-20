<?php
declare(strict_types=1);
// 20.06.22

use AlecRabbit\Spinner\Core\Revolver\Factory\CharRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Factory\StyleRevolverFactory;
use AlecRabbit\Spinner\Core\Twirler\Factory\TwirlerFactory;
use AlecRabbit\Spinner\Core\Twirler\TwirlerContainer;

require_once __DIR__ . '/../bootstrap.php';

$container = new TwirlerContainer();

$twirlerFactory = new TwirlerFactory(
    new  StyleRevolverFactory(),
    new  CharRevolverFactory(),
);

$twirler = $twirlerFactory->create();

$container->addTwirler($twirler);

dump($container);
