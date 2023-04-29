<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Widget\NullWidget;
use AlecRabbit\Spinner\StaticFacade;
use Example\Kernel\App;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$config =
    StaticFacade::getConfigBuilder()
        ->withRootWidget(NullWidget::create())
        ->build();

$app = new App(
    appConfig: $config, spinnerConfig: $config,
);

$app->run();
