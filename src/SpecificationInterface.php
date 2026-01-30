<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(object $object): bool;
}
