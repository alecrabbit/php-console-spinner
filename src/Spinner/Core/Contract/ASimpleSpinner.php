<?php
declare(strict_types=1);
// 11.10.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;

abstract class ASimpleSpinner extends ASpinner implements ISimpleSpinner
{
    protected ITwirlerFactory $twirlerFactory;

    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->twirlerFactory = $config->getTwirlerFactory();
    }

    public function spinner(ITwirler|null $value): void
    {
        $isNullValue = $value === null;
        if ($isNullValue) {
            $this->erase();
        }
        if (!$value instanceof ITwirler) {
            $value = $this->twirlerFactory->spinner($value);
        }
        $this->container->spinner($value);
        if ($isNullValue) {
            $this->spin();
        }
    }

    public function progress(ITwirler|IProgress $value): void
    {
        $isNullValue = $value === null;
        if ($isNullValue) {
            $this->erase();
        }
        if (!$value instanceof ITwirler) {
            $value = $this->twirlerFactory->progress($value);
        }
        $this->container->progress($value);
        if ($isNullValue) {
            $this->spin();
        }
    }

    public function message(ITwirler|IMessage $value): void
    {
        $isNullValue = $value === null;
        if ($isNullValue) {
            $this->erase();
        }
        if (!$value instanceof ITwirler) {
            $value = $this->twirlerFactory->message($value);
        }
        $this->container->message($value);
        if ($isNullValue) {
            $this->spin();
        }
    }
}
