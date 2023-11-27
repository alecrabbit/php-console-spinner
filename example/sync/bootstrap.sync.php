<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Probes;

require_once __DIR__ . '/../bootstrap.php';

Probes::unregister(ILoopProbe::class);
echo 'All loop probes unregistered.' . PHP_EOL;
