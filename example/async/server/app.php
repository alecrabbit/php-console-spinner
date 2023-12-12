<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Probes;

require_once __DIR__ . '/../bootstrap.async.php';

Probes::unregister(RevoltLoopProbe::class);

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Server</title>
    </head>
    <body>
        <p>Date: %s</p>
        <p>Info: %s</p>
    </body>
</html>
HTML;

$http = new React\Http\HttpServer(
    static function (Psr\Http\Message\ServerRequestInterface $request) use ($html): React\Http\Message\Response {
        $datetime = (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED);
        $info = sprintf(
            '%s %s',
            $request->getMethod(),
            $request->getUri()
        );

        echo sprintf('%s Request: %s' . PHP_EOL, $datetime, $info);

        return React\Http\Message\Response::html(
            sprintf(
                $html,
                $datetime,
                $info
            )
        );
    }
);

Facade::getLoop()
    ->delay(
        1,
        static function () use ($http): void {
            $addr = '0.0.0.0:8080';
            $http->listen(new React\Socket\SocketServer($addr));

            echo sprintf('Listening on http://%s' . PHP_EOL, $addr);
        }
    )
;

$spinner = Facade::createSpinner();
