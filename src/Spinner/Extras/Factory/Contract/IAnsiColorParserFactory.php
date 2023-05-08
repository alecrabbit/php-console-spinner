<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;

interface IAnsiColorParserFactory
{
    public function create(OptionStyleMode $styleMode): IAnsiColorParser;
}
