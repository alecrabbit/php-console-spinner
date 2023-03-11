<?php
declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Core\Contract\IFloatValue;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IProgressValue extends IFloatValue
{

    public function getSteps(): int;

    /**
     * @throws InvalidArgumentException
     */
    public function advance(int $steps): void;

    public function finish(): void;

    public function isFinished(): bool;
}