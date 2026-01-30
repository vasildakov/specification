<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests\Assets\User;

use VasilDakov\Specification\Specification;
use VasilDakov\Specification\UserInterface;

/**
 * @extends Specification<UserInterface>
 */
class UserIsGermanSpecification extends Specification
{
    public function isSatisfiedBy(object $object): bool
    {
        return $object->getCountry() == 'Germany';
    }
}
