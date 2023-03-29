<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\StaticWidgetFactory;
use AlecRabbit\Spinner\Extras\ProgressValue;
use AlecRabbit\Spinner\StaticFacade;
use Example\Kernel\App;
use Example\Kernel\AppConfig;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$appConfig = new AppConfig(mainRunTime: 10);

$configBuilder = StaticFacade::getConfigBuilder();

$config = $configBuilder
    ->withRootWidget(StaticWidgetFactory::createEmpty())
    ->build();

$app = new App(
    appConfig: $appConfig,
    spinnerConfig: $config,
);

$progress =
    new ProgressValue(
        autoFinish: true
    );

$app->spinner->add(
    createProgressWidget($progress, 0.3)
);

$app->addCallback(
    static function (App $app) use ($progress): void {
        if (!$progress->isFinished()) {
            $app->spinner->wrap(
                $app->writeln,
                sprintf(
                    '%s %s',
                    str_pad($app->faker->iban(), 35),
                    str_pad($app->faker->ipv6(), 40),
                ),
            );
            $progress->advance();
        }
    },
    0.2
);

$app->run();

