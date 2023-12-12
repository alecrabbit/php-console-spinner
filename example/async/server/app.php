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
        $uri = $request->getUri();

        $datetime = (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED);
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
        )->withStatus(Fig\Http\Message\StatusCodeInterface::STATUS_NOT_FOUND);
    }
);

$addr = '0.0.0.0:8080';

$http->listen(new React\Socket\SocketServer($addr));

Facade::getLoop()
    ->delay(
        1,
        static function () use ($addr): void {
            // this is delayed only to prettify output
            echo sprintf('Listening on http://%s' . PHP_EOL, $addr);
        }
    )
;

Facade::createSpinner(); // yes, assignment to variable is not required 🙂
