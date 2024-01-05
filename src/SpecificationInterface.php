<?php

namespace Vasildakov\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(object $object): bool;
}
