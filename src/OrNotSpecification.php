<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

/**
 * @template T of object
 */
final class OrNotSpecification extends Specification
{
    /**
     * @param Specification<T> $left
     * @param Specification<T> $right
     */
    public function __construct(
        private readonly Specification $left,
        private readonly Specification $right
    ) {
    }

    /**
     * @param T $object
     * @return bool
     */
    public function isSatisfiedBy(object $object): bool
    {
        return $this->left->isSatisfiedBy($object) || ! $this->right->isSatisfiedBy($object);
    }
}
