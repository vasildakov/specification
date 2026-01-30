<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests\Assets\User;

use VasilDakov\Specification\Specification;
use VasilDakov\Specification\UserInterface;

/**
 * @extends Specification<UserInterface>
 */
final class UserIsMaleSpecification extends Specification
{
    public function isSatisfiedBy(object $object): bool
    {
        assert($object instanceof UserInterface);
        return $object->isMale();
    }
}
