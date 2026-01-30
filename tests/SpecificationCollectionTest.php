<?php

declare(strict_types=1);

namespace Vasildakov\SpecificationTests;

use PHPUnit\Framework\TestCase;
use Vasildakov\Specification\SpecificationCollection;
use Vasildakov\Specification\SpecificationInterface;
use Vasildakov\SpecificationTests\Assets\BoolSpecification;

class SpecificationCollectionTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $array = [new BoolSpecification(true)];
        $collection = SpecificationCollection::fromArray($array);

        $this->assertInstanceOf(SpecificationCollection::class, $collection);
    }

    public function testItCanBeCounted(): void
    {
        $array = [
            new BoolSpecification(true),
            new BoolSpecification(false)
        ];

        $collection = SpecificationCollection::fromArray($array);
        $this->assertCount(2, $collection);
    }

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
