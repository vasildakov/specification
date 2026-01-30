<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

/**
 * @template T of object
 */
interface SpecificationInterface
{
    /**
     * @param T $object
     */
    public function isSatisfiedBy(object $object): bool;
}
