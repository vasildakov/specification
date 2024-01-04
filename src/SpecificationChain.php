<?php

namespace Vasildakov\Specification;

use Countable;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

class SpecificationChain implements Countable, IteratorAggregate, SpecificationInterface
{
    /**
     * @var array<SpecificationInterface>
     */
    private array $specifications = [];


    public function count(): int
    {
        return count($this->specifications);
    }

    public function getSpecifications(): array
    {
        return $this->specifications;
    }

    public function addSpecification(SpecificationInterface $specification): void
    {
        $this->specifications[] = $specification;
    }

    /**
     * Returns true only if all specifications are satisfied
     * @param object $candidate
     * @return bool
     */
    public function isSatisfiedBy(object $candidate): bool
    {
        $result = true;
        foreach( $this->specifications as $specification) {
            if ($specification->isSatisfiedBy($candidate)) {
                continue;
            }
            $result = false;
            break;
        }
        return $result;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->specifications);
    }
}
