<?php

declare(strict_types=1);

require_once __DIR__ . '/../tests/bootstrap.php';

// Note: interferes with event-loop autostart
(new NunoMaduro\Collision\Provider())->register(); // [889ad594-ca28-4770-bb38-fd5bd8cb1777]
