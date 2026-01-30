<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use VasilDakov\Specification\SpecificationCollection;
use VasilDakov\Specification\SpecificationCollectionIterator;
use VasilDakov\Specification\SpecificationInterface;

#[CoversClass(SpecificationCollectionIterator::class)]
class SpecificationCollectionIteratorTest extends TestCase
{
    #[Test]
    public function itIteratesOverAllSpecifications(): void
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
        $specifications = SpecificationCollection::fromArray([$specOne, $specTwo]);

        $iterator = new SpecificationCollectionIterator($specifications);

        $result = [];
        foreach ($iterator as $specification) {
            $result[] = $specification;
        }

        $this->assertCount(2, $result);
    }

    #[Test]
    public function itResetsPositionOnRewind(): void
    {
        $specification = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };
        $specifications = SpecificationCollection::fromArray([$specification]);

        $iterator = new SpecificationCollectionIterator($specifications);

        $iterator->next();
        $iterator->rewind();

        $this->assertSame(0, $iterator->key());
    }

    #[Test]
    public function itReturnsCurrentSpecification(): void
    {
        $specification = new class implements SpecificationInterface {
            public function isSatisfiedBy(object $object): bool
            {
                return true;
            }
        };
        $specifications = SpecificationCollection::fromArray([$specification]);

        $iterator = new SpecificationCollectionIterator($specifications);

        $this->assertSame($specification, $iterator->current());
    }

    #[Test]
    public function itAdvancesToNextSpecification(): void
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
        $specifications = SpecificationCollection::fromArray([$specOne, $specTwo]);

        $iterator = new SpecificationCollectionIterator($specifications);

        $iterator->next();

        $this->assertSame(1, $iterator->key());
    }
}
