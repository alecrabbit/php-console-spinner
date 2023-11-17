<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsElement;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use ArrayObject;

final readonly class Settings implements ISettings
{
    /** @var ArrayObject<class-string<ISettingsElement>, ISettingsElement> */
    private ArrayObject $settingsElements;

    public function __construct(ArrayObject $settingElements = new ArrayObject())
    {
        /**
         * @var ArrayObject<class-string<ISettingsElement>, ISettingsElement> $settingElements
         */
        $this->settingsElements = $settingElements;
    }

    public function set(ISettingsElement ...$settingsElements): void
    {
        foreach ($settingsElements as $settingsElement) {
            $identifier = $settingsElement->getIdentifier();
            self::assertIdentifier($identifier);
            $this->settingsElements->offsetSet($identifier, $settingsElement);
        }
    }

    /**
     * @param class-string<ISettingsElement> $id
     * @throws InvalidArgument
     */
    private static function assertIdentifier(string $id): void
    {
        if (!interface_exists($id)) {
            throw new InvalidArgument(
                sprintf('Identifier "%s" is not an interface.', $id)
            );
        }
        if (!is_a($id, ISettingsElement::class, true)) {
            throw new InvalidArgument(
                sprintf('Identifier "%s" is not an instance of "%s".', $id, ISettingsElement::class)
            );
        }
    }

    /** @inheritDoc */
    public function get(string $id): ?ISettingsElement
    {
        self::assertIdentifier($id);

        return
            $this->settingsElements->offsetExists($id)
                ? $this->settingsElements->offsetGet($id)
                : null;
    }
}
