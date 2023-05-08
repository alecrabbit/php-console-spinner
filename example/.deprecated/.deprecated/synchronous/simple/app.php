<?php

declare(strict_types=1);

use Example\Kernel\App;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$app = new App();

$app->run();
