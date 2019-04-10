<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Spinner;

class SimpleSpinner extends Spinner
{
    protected const INTERVAL = 0.16;
    protected const SYMBOLS = SpinnerSymbols::SIMPLE;
}
