<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests\Assets;

use Vasildakov\Specification\Specification;
use Vasildakov\Specification\UserInterface;

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
