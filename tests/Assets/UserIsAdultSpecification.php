<?php

namespace Vasildakov\SpecificationTests\Assets;

use Vasildakov\Specification\Specification;
use Vasildakov\Specification\UserInterface;

class UserIsAdultSpecification extends Specification
{
    /**
     * @param UserInterface $object
     * @return bool
     */
    public function isSatisfiedBy(object $object): bool
    {
        return $object->isAdult();
    }
}
