<?php

namespace Vasildakov\Specification;

class CompositeSpecification implements SpecificationInterface
{
    /**
     * @var array<SpecificationInterface>
     */
    private array $specifications = [];


    public function getSpecifications(): array
    {
        return $this->specifications;
    }

    public function addSpecification(SpecificationInterface $specification): void
    {
        $this->specifications[] = $specification;
    }

    public function isSatisfiedBy(object $candidate): bool
    {
        $result = true;
        foreach($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($candidate)) {
                continue;
            }
            $result = false;
            break;
        }
        return $result;
    }
}
