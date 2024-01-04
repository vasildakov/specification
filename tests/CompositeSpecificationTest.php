<?php

namespace Vasildakov\SpecificationTests;

use PHPUnit\Framework\TestCase;
use Vasildakov\Specification\CompositeSpecification;
use Vasildakov\Specification\SpecificationInterface;

final class CompositeSpecificationTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $composite = new CompositeSpecification();

        self::assertInstanceOf(CompositeSpecification::class, $composite);
        self::assertInstanceOf(SpecificationInterface::class, $composite);
    }

    public function testItCanAddSpecifications(): void
    {
        $composite = new CompositeSpecification();

        $composite->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return true;
                }
            }
        );

        self::assertCount(1, $composite->getSpecifications());
    }

    public function testItBeSatisfiedWhenAllSpecsAreSatisfied(): void
    {
        $composite = new CompositeSpecification();

        $composite->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return true;
                }
            }
        );
        $composite->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return true;
                }
            }
        );

        self::assertTrue($composite->isSatisfiedBy(new \stdClass()));
    }

    public function testItWontSatisfiedIfOneSpecIsNoySatisfied(): void
    {
        $composite = new CompositeSpecification();

        $composite->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return true;
                }
            }
        );
        $composite->addSpecification(
            new class implements SpecificationInterface {
                public function isSatisfiedBy(object $candidate): bool {
                    return false;
                }
            }
        );

        self::assertFalse($composite->isSatisfiedBy(new \stdClass()));
    }
}
