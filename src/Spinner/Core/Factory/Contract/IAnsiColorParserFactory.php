<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;

interface IAnsiColorParserFactory
{
    public function create(OptionStyleMode $styleMode): IAnsiColorParser;
}
