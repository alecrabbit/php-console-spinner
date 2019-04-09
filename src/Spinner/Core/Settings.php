<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contracts\SettingsInterface;

class Settings implements SettingsInterface
{
    /** @var null|string */
    protected $message;
    /** @var null|string */
    protected $prefix;
    /** @var null|string */
    protected $suffix;
    /** @var null|string */
    protected $paddingStr;

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Settings
     */
    public function setMessage(?string $message): Settings
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @param null|string $prefix
     * @return Settings
     */
    public function setPrefix(?string $prefix): Settings
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * @param null|string $suffix
     * @return Settings
     */
    public function setSuffix(?string $suffix): Settings
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaddingStr(): ?string
    {
        return $this->paddingStr;
    }

    /**
     * @param null|string $paddingStr
     * @return Settings
     */
    public function setPaddingStr(?string $paddingStr): Settings
    {
        $this->paddingStr = $paddingStr;
        return $this;
    }
}
