<?php

namespace Vasildakov\Specification;

/**
 * @template T
 * @extends Specification<T>
 */
final class OrSpecification extends Specification
{
    /**
     * @var Specification<T>
     */
    private Specification $one;

    /**
     * @var Specification<T>
     */
    private Specification $other;

    /**
     * @param Specification<T> $one
     * @param Specification<T> $other
     */
    public function __construct(Specification $one, Specification $other)
    {
        $this->one   = $one;
        $this->other = $other;
    }

    /**
     * @param T $object
     */
    public function isSatisfiedBy($object): bool
    {
        return $this->one->isSatisfiedBy($object) || $this->other->isSatisfiedBy($object);
    }

    /**
     * @return Specification<T>
     */
    public function one(): Specification
    {
        return $this->one;
    }

    /**
     * @return Specification<T>
     */
    public function other(): Specification
    {
        return $this->other;
    }

}