<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;

final readonly class Settings implements ISettings
{
    /** @var ArrayObject<class-string<ISettingsElement>, ISettingsElement> */
    protected ArrayObject $settingElements;

    /**
     * @param ArrayObject<class-string<ISettingsElement>, ISettingsElement> $settingElements
     */
    public function __construct(ArrayObject $settingElements = new ArrayObject())
    {
        $this->settingElements = $settingElements;
    }

    public function set(ISettingsElement ...$settingsElements): void
    {
        foreach ($settingsElements as $settingsElement) {
            $identifier = $settingsElement->getIdentifier();

            self::assertIdentifier($identifier);
            $this->settingElements->offsetSet($identifier, $settingsElement);
        }
    }

    /**
     * @param class-string<ISettingsElement> $id
     */
    private static function assertIdentifier(string $id): void
    {
        if (!interface_exists($id)) {
            throw new InvalidArgumentException(
                sprintf('Identifier "%s" is not an interface.', $id)
            );
        }
        if (!is_a($id, ISettingsElement::class, true)) {
            throw new InvalidArgumentException(
                sprintf('Identifier "%s" is not an instance of "%s".', $id, ISettingsElement::class)
            );
        }
    }

    /** @inheritDoc */
    public function get(string $id): ?ISettingsElement
    {
        self::assertIdentifier($id);
        return $this->settingElements->offsetGet($id);
    }
}
