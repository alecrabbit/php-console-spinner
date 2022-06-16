<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IStyle;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;

final class Style implements IStyle
{
    protected function __construct(
        public readonly string $sequence,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(mixed $element = null): IStyle
    {
        if ($element instanceof IStyle) {
            return $element;
        }
        if (null === $element) {
            $element = C::STR_PLACEHOLDER;
        }
        if (is_string($element)) {
            if (C::EMPTY_STRING === $element) {
                $element = C::STR_PLACEHOLDER;
            }
            return new Style($element);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unsupported style element: [%s].',
                get_debug_type($element)
            )
        );
    }
//    /**
//     * @throws InvalidArgumentException
//     */
//    public static function create(mixed $element, ?string $format = null): IStyle
//    {
//        if ($element instanceof IStyle) {
//            return $element;
//        }
//        if (is_int($element) || is_float($element) || $element instanceof Stringable) {
//            $element = (string)$element;
//        }
//        if (is_string($element)) {
//            $sequence = Sequencer::colorSequence(sprintf($format ?? '%s', $element) . '%s');
//            return new Style($sequence);
//        }
//        throw new InvalidArgumentException(
//            sprintf(
//                'Unsupported frame element: [%s].',
//                get_debug_type($element)
//            )
//        );
//    }

    public function __toString(): string
    {
        return $this->sequence;
    }
}
