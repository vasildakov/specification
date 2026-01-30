<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Vasildakov\Specification\OrSpecification;
use Vasildakov\Specification\SpecificationInterface;

#[CoversClass(OrSpecification::class)]
final class OrSpecificationTest extends TestCase
{
    #[Test]
    public function itReturnsTrueWhenEitherSpecificationIsSatisfied(): void
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

        $orSpecification = new OrSpecification($specOne, $specTwo);

        $this->assertTrue($orSpecification->isSatisfiedBy(new \stdClass()));
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

        $orSpecification = new OrSpecification($specOne, $specTwo);

        $this->assertFalse($orSpecification->isSatisfiedBy(new \stdClass()));
    }

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

        $orSpecification = new OrSpecification($specOne, $specTwo);

        $this->assertTrue($orSpecification->isSatisfiedBy(new \stdClass()));
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

        $orSpecification = new OrSpecification($specOne, $specTwo);

        $this->assertSame($specOne, $orSpecification->one());
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

        $orSpecification = new OrSpecification($specOne, $specTwo);

        $this->assertSame($specTwo, $orSpecification->other());
    }

}