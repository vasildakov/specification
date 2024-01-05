<?php

namespace Vasildakov\SpecificationTests\Assets;

use Vasildakov\Specification\Specification;

class CancelledOrderSpecification extends Specification
{
    public function isSatisfiedBy($order): bool
    {
        return $order->isCancelled();
    }
}
