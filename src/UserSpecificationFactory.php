<?php

declare(strict_types=1);

namespace VasilDakov\Specification;

/**
 * An example specification chain factory
 */
final class UserSpecificationFactory
{
    /**
     * Provide additional dependencies or context that is not
     * directly related to the candidate
     */
    public function __construct()
    {
    }

    /**
     * @param object $candidate
     * @return SpecificationChain
     */
    public function __invoke(object $candidate): SpecificationChain
    {
        $collection = SpecificationCollection::fromArray([]);

        $chain = new SpecificationChain($collection);

        // add age specification
        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $object): bool
                {
                    return $object->getAge() >= 18;
                }
            }
        );

        // add country specification
        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $object): bool
                {
                    return $object->getCountry() == 'Bulgaria';
                }
            }
        );

        // add gender specification
        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $object): bool
                {
                    return $object->getGender() == 'Male';
                }
            }
        );

        // additional specs could be added

        return $chain;
    }
}
