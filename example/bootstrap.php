<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;

$cloner = new VarCloner();
$fallbackDumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg']) ? new CliDumper() : new HtmlDumper();

$dumper = new ServerDumper(getAddress(getenv('COMMON_VAR_DUMPER_SERVER')), $fallbackDumper, [
    'cli' => new CliContextProvider(),
    'source' => new SourceContextProvider(),
]);

VarDumper::setHandler(static function ($var) use ($cloner, $dumper) {
    $dumper->dump($cloner->cloneVar($var));
});

(new \NunoMaduro\Collision\Provider())->register();

function getAddress(false|string $srv): string
{
    return
        false === $srv
            ? 'tcp://127.0.0.1:9912'
            : sprintf('tcp://%s', $srv);
}
