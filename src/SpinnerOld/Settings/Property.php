<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings;

class Property
{
    /** @var mixed */
    protected $value;
    /** @var bool */
    protected $isDefault;

    /**
     * SettingsValue constructor.
     * @param mixed $defaultValue
     */
    public function __construct($defaultValue = null)
    {
        $this->value = $defaultValue;
        $this->isDefault = true;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
        $this->isDefault = false;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @return bool
     */
    public function isNotDefault(): bool
    {
        return !$this->isDefault;
    }
}
