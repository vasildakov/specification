<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

/**
 * @template T of object
 */
abstract class Specification implements SpecificationInterface
{
    /**
     * @param T $object
     * @return bool
     */
    abstract public function isSatisfiedBy(object $object): bool;

    /**
     * @param Specification<T> $specification
     * @return AndSpecification<T>
     */
    public function and(Specification $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * @param Specification<T> $specification
     * @return OrSpecification<T>
     */
    public function or(Specification $specification): OrSpecification
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * @return NotSpecification<T>
     */
    public function not(): NotSpecification
    {
        return new NotSpecification($this);
    }

    public function andNot(Specification $specification): AndNotSpecification
    {
        return new AndNotSpecification($this, $specification);
    }
}
