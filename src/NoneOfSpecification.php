<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

/**
 * @template T
 * @extends Specification<T>
 */
final class NoneOfSpecification extends Specification
{
    /**
     * @var Specification<T>[]
     */
    private array $specifications;

    /**
     * @param Specification<T> ...$specifications
     */
    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * @param T $object
     */
    public function isSatisfiedBy($object): bool
    {
        foreach ($this->specifications() as $specification) {
            if ($specification->isSatisfiedBy($object)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Specification<T>[]
     */
    public function specifications(): array
    {
        return $this->specifications;
    }
}