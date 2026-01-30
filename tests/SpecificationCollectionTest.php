<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use VasilDakov\Specification\SpecificationCollection;
use VasilDakov\Specification\SpecificationInterface;
use VasilDakov\SpecificationTests\Assets\BoolSpecification;

#[CoversClass(SpecificationCollection::class)]
final class SpecificationCollectionTest extends TestCase
{
    #[Test]
    public function testItCanBeCreated(): void
    {
        $array = [new BoolSpecification(true)];
        $collection = SpecificationCollection::fromArray($array);

        $this->assertInstanceOf(SpecificationCollection::class, $collection);
    }

    #[Test]
    public function testItCanBeCounted(): void
    {
        $array = [
            new BoolSpecification(true),
            new BoolSpecification(false)
        ];

        $collection = SpecificationCollection::fromArray($array);
        $this->assertCount(2, $collection);
    }

    #[Test]
    public function testItCanBeIterated(): void
    {
        $array = [
            new BoolSpecification(true),
            new BoolSpecification(false)
        ];
        $collection = SpecificationCollection::fromArray($array);
        foreach ($collection as $specification) {
            $this->assertInstanceOf(SpecificationInterface::class, $specification);
        }
    }

    #[Test]
    public function testItCanAddSpecification(): void
    {
        $array = [
            new BoolSpecification(true),
            new BoolSpecification(false)
        ];
        $collection = SpecificationCollection::fromArray($array);

        $collection->add(new BoolSpecification(true));

        $this->assertCount(3, $collection);
    }
}
