<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

interface ITwirlerFactory
{
    public function create(?IStyleRevolver $styleRevolver = null, ?ICharRevolver $charRevolver = null): ITwirler;
}
