<?php
declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Core\Contract\IMultiSpinner;
use AlecRabbit\Spinner\Core\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Exception\MethodNotImplementedException;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class MultiSpinner extends ABaseSpinner implements IMultiSpinner
{
    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->twirlerContainer = $config->getTwirlers();
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        // FIXME (2022-06-19 19:40) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }

    public function getInterval(): IInterval
    {
        // FIXME (2022-06-19 19:39) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }
}
