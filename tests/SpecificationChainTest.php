<?php

namespace Vasildakov\SpecificationTests;

use PHPUnit\Framework\TestCase;
use Vasildakov\Specification\SpecificationChain;
use Vasildakov\Specification\SpecificationInterface;
use Vasildakov\Specification\UserInterface;
use Vasildakov\Specification\UserSpecificationFactory;

final class SpecificationChainTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $chain = new SpecificationChain();

        self::assertInstanceOf(SpecificationChain::class, $chain);
        self::assertInstanceOf(SpecificationInterface::class, $chain);
    }

    public function testItCanAddSpecifications(): void
    {
        $chain = new SpecificationChain();

        // initially the chain is empty
        self::assertCount(0, $chain->getSpecifications());

        $chain->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return true;
                }
            }
        );

        // the chain should have only one spec
        self::assertCount(1, $chain->getSpecifications());
    }

    public function testItBeSatisfiedWhenAllSpecsAreSatisfied(): void
    {
        $candidate = self::candidateFactory(country: 'Bulgaria', age: 49, gender: 'Male');

        $chain = (new UserSpecificationFactory())($candidate);

        self::assertTrue($chain->isSatisfiedBy($candidate));
    }

    public function testItWontSatisfiedIfOneSpecIsNoySatisfied(): void
    {
        $candidate = self::candidateFactory(country: 'Germany', age: 25, gender: 'Female');

        $chain = (new UserSpecificationFactory())($candidate);

        self::assertFalse($chain->isSatisfiedBy($candidate));
    }


    private static function candidateFactory(string $country, int $age, string $gender): UserInterface
    {
        return new class($country, $age, $gender) implements UserInterface {
            public function __construct(
                private readonly string $country,
                private readonly int $age,
                private readonly string $gender
            ) {}

            public function getCountry(): string {
                return $this->country;
            }

            public function getAge(): int {
                return $this->age;
            }

            public function getGender(): string {
                return $this->gender;
            }
        };
    }
}
