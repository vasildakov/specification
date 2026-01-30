<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

use Countable;
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

    public static function fromCollection(SpecificationCollection $specifications): self
    {
        return new self($specifications);
    }

    public static function fromArray(array $specifications): self
    {
        return new self(SpecificationCollection::fromArray($specifications));
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
     *
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

    /**
     * @return Traversable<non-negative-int, SpecificationInterface>
     */
    public function getIterator(): Traversable
    {
        return $this->specifications->getIterator();
    }
}
