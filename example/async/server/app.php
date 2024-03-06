<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Probes;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$addr = '0.0.0.0:8080'; // Listen on all interfaces, port 8080

// by default React\Http\HttpServer requires React\EventLoop\LoopInterface as event loop
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
        $uri = $request->getUri();

        $info = sprintf(
            '%s %s',
            $request->getMethod(),
            $uri
        );

        // for simplicity this output is not "wrapped", see IDriver::wrap()
        echo sprintf('%s %s' . PHP_EOL, $datetime, $info);

        if (str_ends_with($uri->getPath(), 'favicon.ico')) {
            return React\Http\Message\Response::plaintext('')
                ->withStatus(Fig\Http\Message\StatusCodeInterface::STATUS_NOT_FOUND)
            ;
        }

        return React\Http\Message\Response::html(
            sprintf(
                $html,
                $datetime,
                $info
            )
        )->withStatus(Fig\Http\Message\StatusCodeInterface::STATUS_OK);
    }
);

$http->listen(new React\Socket\SocketServer($addr));

// this is delayed only to prettify output
Facade::getLoop()
    ->delay(
        1,
        static function () use ($addr): void {
            echo sprintf('Listening on http://%s' . PHP_EOL, $addr);
        }
    )
;

Facade::createSpinner(); // yes, assignment to variable is not required 🙂
