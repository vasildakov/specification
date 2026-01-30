<?php

namespace Vasildakov\SpecificationTests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Vasildakov\Specification\SpecificationChain;
use Vasildakov\Specification\SpecificationCollection;
use Vasildakov\Specification\SpecificationCollectionIterator;
use Vasildakov\Specification\SpecificationInterface;
use Vasildakov\Specification\UserInterface;
use Vasildakov\Specification\UserSpecificationFactory;
use Vasildakov\SpecificationTests\Assets\BoolSpecification;

final class SpecificationChainTest extends TestCase
{
    #[Test]
    public function itCanBeCreated(): void
    {
        $collection = SpecificationCollection::fromArray([
            new BoolSpecification(true),
        ]);

        $chain = new SpecificationChain($collection);

        $this->assertInstanceOf(SpecificationChain::class, $chain);
        $this->assertInstanceOf(SpecificationInterface::class, $chain);
    }

    #[Test]
    public function itCanAddSpecifications(): void
    {
        $collection = SpecificationCollection::fromArray([]);
        $chain = new SpecificationChain($collection);

        // Assert it starts empty
        $this->assertCount(0, $chain);

        // Then add specifications
        $spec = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };

        $chain->addSpecification($spec);
        $this->assertCount(1, $chain);
    }

    #[Test]
    public function testItBeSatisfiedWhenAllSpecsAreSatisfied(): void
    {
        $candidate = self::candidateFactory(country: 'Bulgaria', age: 49, gender: 'Male');

        $chain = (new UserSpecificationFactory())($candidate);

        $this->assertTrue($chain->isSatisfiedBy($candidate));
    }

    #[Test]
    public function testItWontSatisfiedIfOneSpecIsNoySatisfied(): void
    {
        $candidate = self::candidateFactory(country: 'Germany', age: 25, gender: 'Female');

        $chain = (new UserSpecificationFactory())($candidate);

        $this->assertFalse($chain->isSatisfiedBy($candidate));
    }


    private static function candidateFactory(string $country, int $age, string $gender): UserInterface
    {
        return new readonly class ($country, $age, $gender) implements UserInterface {
            public function __construct(
                private string $country,
                private int $age,
                private string $gender
            ) {
            }

            public function getCountry(): string
            {
                return $this->country;
            }

            public function getAge(): int
            {
                return $this->age;
            }

            public function getGender(): string
            {
                return $this->gender;
            }

            public function isMale(): bool
            {
                return $this->getGender() == 'Male';
            }

            public function isFemale(): bool
            {
                return $this->getGender() == 'Female';
            }

            public function isAdult(): bool
            {
                return $this->getAge() >= 18;
            }
        };
    }

    #[Test]
    public function itCanReturnCollectionIterator(): void
    {
        $collection = SpecificationCollection::fromArray([
            new BoolSpecification(true),
        ]);

        $chain = new SpecificationChain($collection);

        $this->assertInstanceOf(SpecificationCollectionIterator::class, $chain->getIterator());
    }

    #[Test]
    public function itCanGetAllSpecification(): void
    {
        $collection = SpecificationCollection::fromArray([
            new BoolSpecification(true),
        ]);

        $chain = new SpecificationChain($collection);

        $this->assertCount(1, $chain->getSpecifications());
    }
}
