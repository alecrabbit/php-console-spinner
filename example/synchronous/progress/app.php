<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Extras\FractionValue;
use Example\Kernel\App;
use Example\Kernel\AppConfig;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$app = new App(
    appConfig: new AppConfig(mainRunTime: 10),
);

$progress =
    new FractionValue(
        steps: 20,
        autoFinish: true
    );

$app->spinner->add(
    createProgressWidget($progress, 0.4)
);

$count = 0;

$app->addCallback(
    static function (App $app) use ($progress, &$count): void {
        if (!$progress->isFinished()) {
            $app->spinner->wrap(
                $app->writeln,
                sprintf(
                    '%s %s %s',
                    str_pad(sprintf('%s.', ++$count), 4),
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

