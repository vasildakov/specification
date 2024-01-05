<?php

namespace Vasildakov\SpecificationTests\Assets;

use InvalidArgumentException;
use Vasildakov\Specification\Specification;

class UnshippedOrderSpecification extends Specification
{
    public function isSatisfiedBy(object $object): bool
    {
        if ( !$object instanceof Order) {
            throw new InvalidArgumentException();
        }
        return !$object->isShipped();
    }
}
