<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigElement;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;

final readonly class Config implements IConfig
{
    /**
     * @var ArrayObject<class-string<IConfigElement>, IConfigElement>
     */
    protected ArrayObject $configElements;

    public function __construct(
        ArrayObject $configElements = new ArrayObject(),
    ) {
        $this->configElements = $configElements;
    }

    /** @inheritDoc */
    public function set(IConfigElement ...$configElements): void
    {
        foreach ($configElements as $configElement) {
            $identifier = $configElement->getIdentifier();
            self::assertIdentifier($identifier);
            $this->configElements->offsetSet($identifier, $configElement);
        }
    }

    /**
     * @param class-string<IConfigElement> $id
     * @throws InvalidArgumentException
     */
    private static function assertIdentifier(string $id): void
    {
        if (!interface_exists($id)) {
            throw new InvalidArgumentException(
                sprintf('Identifier "%s" is not an interface.', $id)
            );
        }
        if (!is_a($id, IConfigElement::class, true)) {
            throw new InvalidArgumentException(
                sprintf('Identifier "%s" is not an instance of "%s".', $id, IConfigElement::class)
            );
        }
    }

    /** @inheritDoc */
    public function get(string $id): IConfigElement
    {
        self::assertIdentifier($id);
        if (!$this->configElements->offsetExists($id)) {
            throw new InvalidArgumentException(
                sprintf('Identifier "%s" is not set.', $id)
            );
        }
        return $this->configElements->offsetGet($id);
    }

}
