<?php

namespace Vasildakov\SpecificationTests\Assets;

use Vasildakov\Specification\Specification;

class PaidOrderSpecification extends Specification
{
    public function isSatisfiedBy($order): bool
    {
        return $order->isPaid();
    }
}
