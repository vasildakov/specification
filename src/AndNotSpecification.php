<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

/**
 * @template T
 * @extends Specification<T>
 */
final class AndNotSpecification extends Specification
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
     * @param Specification $one
     * @param Specification $other
     */
    public function __construct(Specification $one, Specification $other)
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
        // true and false
        return $this->one()->isSatisfiedBy($object) && ! $this->other()->isSatisfiedBy($object);
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
