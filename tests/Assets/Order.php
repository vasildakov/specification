<?php

namespace Vasildakov\SpecificationTests\Assets;

class Order
{
    public function isPaid(): bool
    {
        return true;
    }

    public function isShipped(): bool
    {
        return false;
    }

    public function isCancelled(): bool
    {
        return false;
    }
}
