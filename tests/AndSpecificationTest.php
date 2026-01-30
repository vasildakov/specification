<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use VasilDakov\Specification\AndSpecification;
use VasilDakov\Specification\SpecificationInterface;

#[CoversClass(AndSpecification::class)]
class AndSpecificationTest extends TestCase
{
    #[Test]
    public function itReturnsTrueWhenBothSpecificationsAreSatisfied(): void
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

        $andSpecification = new AndSpecification($specOne, $specTwo);

        $this->assertTrue($andSpecification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itReturnsFalseWhenOneSpecificationIsNotSatisfied(): void
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

        $andSpecification = new AndSpecification($specOne, $specTwo);

        $this->assertFalse($andSpecification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itReturnsFalseWhenBothSpecificationsAreNotSatisfied(): void
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

        $andSpecification = new AndSpecification($specOne, $specTwo);

        $this->assertFalse($andSpecification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itCanRetrieveTheFirstSpecification(): void
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

        $andSpecification = new AndSpecification($specOne, $specTwo);

        $this->assertSame($specOne, $andSpecification->one());
    }

    #[Test]
    public function itCanRetrieveTheSecondSpecification(): void
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

        $andSpecification = new AndSpecification($specOne, $specTwo);

        $this->assertSame($specTwo, $andSpecification->other());
    }
}
