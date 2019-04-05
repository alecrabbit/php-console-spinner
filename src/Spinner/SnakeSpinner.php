<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class SnakeSpinner extends AbstractSpinner
{
    /**
     * @return Circular
     */
    protected function getSymbols(): Circular
    {
        return new Circular(['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏']);
    }
}
