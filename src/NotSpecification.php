<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

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
}
