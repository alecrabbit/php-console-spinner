<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Widget\NullWidget;
use AlecRabbit\Spinner\Factory;
use Example\Kernel\App;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$app = new App();

$app->run();
