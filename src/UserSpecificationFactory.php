<?php

namespace Vasildakov\Specification;

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
        $chain = new SpecificationChain();

        // add age specification
        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return $candidate->getAge() >= 18;
                }
            }
        );

        // add country specification
        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return $candidate->getCountry() == 'Bulgaria';
                }
            }
        );

        // add gender specification
        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return $candidate->getGender() == 'Male';
                }
            }
        );

        // additional specs could be added

        return $chain;
    }
}
