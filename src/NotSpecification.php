<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

/**
 * @template T
 * @extends Specification<T>
 */
final class NotSpecification extends Specification
{
    /**
     * @var Specification<T>
     */
    private Specification $specification;

    /**
     * @param Specification<T> $specification
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @param T $object
     */
    public function isSatisfiedBy($object): bool
    {
        return ! $this->specification->isSatisfiedBy($object);
    }

    /**
     * @return Specification<T>
     */
    public function specification(): Specification
    {
        return $this->specification;
    }
}
