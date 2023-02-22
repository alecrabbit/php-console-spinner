<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Widget\NullWidget;
use AlecRabbit\Spinner\Factory;
use Example\Kernel\App;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$config =
    Factory::getConfigBuilder()
        ->withMainWidget(NullWidget::create())
        ->build();

$app = new App(
    appConfig: $config, spinnerConfig: $config,
);

$app->run();

