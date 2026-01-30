<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests\Assets;

use Vasildakov\Specification\Specification;
use Vasildakov\Specification\UserInterface;

/**
 * @extends Specification<UserInterface>
 */
final class UserIsAdultSpecification extends Specification
{
    public function isSatisfiedBy(object $object): bool
    {
        return $object->isAdult();
    }
}
