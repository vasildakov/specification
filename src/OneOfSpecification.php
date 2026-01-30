<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

/**
 * @template T
 * @extends Specification<T>
 */
final class OneOfSpecification extends Specification
{
    /**
     * @var SpecificationInterface<T>[]
     */
    private array $specifications;

    /**
     * @param SpecificationInterface<T> ...$specifications
     */
    public function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * @param T $object
     */
    public function isSatisfiedBy($object): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($object)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return SpecificationInterface<T>[]
     */
    public function specifications(): array
    {
        return $this->specifications;
    }
}