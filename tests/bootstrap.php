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

$dumper = new ServerDumper(getHost(), getFallbackDumper(), [
    'cli' => new CliContextProvider(),
    'source' => new SourceContextProvider(),
]);

VarDumper::setHandler(static function ($var) use ($cloner, $dumper): void {
    $dumper->dump($cloner->cloneVar($var)); // intentional dump
});

function getFallbackDumper(): HtmlDumper|CliDumper
{
    return in_array(PHP_SAPI, ['cli', 'phpdbg'], true) ? new CliDumper() : new HtmlDumper();
}

function getAddress(false|string $srv): string
{
    return $srv === false
        ? 'tcp://127.0.0.1:9912'
        : sprintf('tcp://%s', $srv);
}

function getHost(): string
{
    return getAddress(getenv('VAR_DUMPER_SERVER'));
}
