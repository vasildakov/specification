<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Vasildakov\Specification\OneOfSpecification;
use Vasildakov\Specification\SpecificationInterface;

#[CoversClass(OneOfSpecification::class)]
class OneOfSpecificationTest extends TestCase
{
    #[Test]
    public function itReturnsTrueWhenAtLeastOneSpecificationIsSatisfied(): void
    {
        $specOne = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return false;
            }
        };

        $specTwo = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };

        $oneOfSpecification = new OneOfSpecification($specOne, $specTwo);

        $this->assertTrue($oneOfSpecification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itReturnsFalseWhenNoSpecificationsAreSatisfied(): void
    {
        $specOne = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return false;
            }
        };

        $specTwo = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return false;
            }
        };

        $oneOfSpecification = new OneOfSpecification($specOne, $specTwo);

        $this->assertFalse($oneOfSpecification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itReturnsTrueWhenAllSpecificationsAreSatisfied(): void
    {
        $specOne = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };

        $specTwo = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };

        $oneOfSpecification = new OneOfSpecification($specOne, $specTwo);

        $this->assertTrue($oneOfSpecification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itCanRetrieveAllSpecifications(): void
    {
        $specOne = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };

        $specTwo = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return false;
            }
        };

        $oneOfSpecification = new OneOfSpecification($specOne, $specTwo);

        $this->assertSame([$specOne, $specTwo], $oneOfSpecification->specifications());
    }
}
