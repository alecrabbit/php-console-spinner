<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\A;

use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ReflectionFunction;
use Throwable;

abstract class ATimer implements ITimer
{
    public function __construct(
        protected TimeUnit $unit,
        protected \Closure $timeFunction,
    ) {
        self::assertTimeFunction($timeFunction);
    }

    protected static function assertTimeFunction(\Closure $timeFunction): void
    {
        try {
            $timeFunction();
        } catch (Throwable $e) {
            throw new InvalidArgumentException(
                'Invoke of time function throws: ' . $e->getMessage(),
                previous: $e,
            );
        }
        $reflection = new ReflectionFunction($timeFunction);

        $returnType = $reflection->getReturnType();
        if ($returnType === null) {
            throw new InvalidArgumentException(
                'Return type of time function is not specified.'
            );
        }
        self::assertReturnType($returnType);
    }

    protected static function assertReturnType(
        \ReflectionIntersectionType|\ReflectionNamedType|\ReflectionUnionType $returnType
    ): void {
        match (true) {
            $returnType instanceof \ReflectionIntersectionType => self::assertIntersectionType($returnType),
            $returnType instanceof \ReflectionUnionType => self::assertUnionType($returnType),
            $returnType instanceof \ReflectionNamedType => self::assertNamedType($returnType),
        };
    }

    private static function assertIntersectionType(\ReflectionIntersectionType $intersectionType)
    {
        throw new InvalidArgumentException(
            'Unexpected intersection type.',
        );
    }

    private static function assertUnionType(\ReflectionUnionType $unionType)
    {
        foreach ($unionType->getTypes() as $type) {
            self::assertReturnType($type);
        }
    }

    private static function assertNamedType(\ReflectionNamedType $namedType)
    {
        $type = $namedType->getName();
        if ($type === 'null' || $namedType->allowsNull()) {
            throw new InvalidArgumentException(
                'Time function return type allows null.',
            );
        }
        if ($type !== 'float' && $type !== 'int') {
            throw new InvalidArgumentException(
                sprintf(
                    'Time function must return "int|float"(e.g. "%s"), instead return type is "%s".',
                    'fn(): int|float => 0.0',
                    $type,
                )
            );
        }
    }

    public function getUnit(): TimeUnit
    {
        return $this->unit;
    }

    public function now(): int|float
    {
        return $this->timeFunction->__invoke();
    }
}
