<?php

declare(strict_types=1);

namespace Vasildakov\Specification;

use Countable;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

class SpecificationChain implements Countable, IteratorAggregate, SpecificationInterface
{
    /**
     * @var SpecificationCollection
     */
    private SpecificationCollection $specifications;

    public function __construct(SpecificationCollection $specifications)
    {
        $this->specifications = $specifications;
    }

    public function count(): int
    {
        return count($this->specifications);
    }

    public function getSpecifications(): SpecificationCollection
    {
        return $this->specifications;
    }

    public function addSpecification(SpecificationInterface $specification): void
    {
        $this->specifications->add($specification);
    }

    /**
     * Returns true only if all specifications are satisfied
     * @param object $object
     * @return bool
     */
    public function isSatisfiedBy(object $object): bool
    {
        $result = true;
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($object)) {
                continue;
            }
            $result = false;
            break;
        }
        return $result;
    }

    public function getIterator(): Traversable
    {
        return $this->specifications->getIterator();
    }
}
