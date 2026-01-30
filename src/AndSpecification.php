<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

/**
 * @template T
 * @extends Specification<T>
 */
final class AndSpecification extends Specification
{
    /**
     * @var SpecificationInterface<T>
     */
    private SpecificationInterface $one;

    /**
     * @var SpecificationInterface<T>
     */
    private SpecificationInterface $other;

    /**
     * @param SpecificationInterface $one
     * @param SpecificationInterface $other
     */
    public function __construct(SpecificationInterface $one, SpecificationInterface $other)
    {
        $this->one   = $one;
        $this->other = $other;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function isSatisfiedBy(object $object): bool
    {
        return $this->one()->isSatisfiedBy($object) && $this->other()->isSatisfiedBy($object);
    }

    /**
     * @return SpecificationInterface<T>
     */
    public function one(): SpecificationInterface
    {
        return $this->one;
    }

    /**
     * @return SpecificationInterface<T>
     */
    public function other(): SpecificationInterface
    {
        return $this->other;
    }
}