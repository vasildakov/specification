<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests\Assets;

use InvalidArgumentException;
use Vasildakov\Specification\Specification;

/**
 * @extends Specification<Order>
 */
final class UnshippedOrderSpecification extends Specification
{
    public function isSatisfiedBy(object $object): bool
    {
        assert($object instanceof Order);
        return ! $object->isShipped();
    }
}
