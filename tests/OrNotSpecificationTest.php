<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use VasilDakov\Specification\OrNotSpecification;
use VasilDakov\Specification\Specification;

class OrNotSpecificationTest extends TestCase
{
    #[Test]
    public function itReturnsTrueWhenLeftSpecificationIsSatisfied(): void
    {
        $left = $this->createStub(Specification::class);
        $right = $this->createStub(Specification::class);

        $left->method('isSatisfiedBy')->willReturn(true);
        $right->method('isSatisfiedBy')->willReturn(false);

        $specification = new OrNotSpecification($left, $right);

        $this->assertTrue($specification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itReturnsTrueWhenRightSpecificationIsNotSatisfied(): void
    {
        $left = $this->createStub(Specification::class);
        $right = $this->createStub(Specification::class);

        $left->method('isSatisfiedBy')->willReturn(false);
        $right->method('isSatisfiedBy')->willReturn(false);

        $specification = new OrNotSpecification($left, $right);

        $this->assertTrue($specification->isSatisfiedBy(new \stdClass()));
    }

    #[Test]
    public function itReturnsFalseWhenNeitherConditionIsMet(): void
    {
        $left = $this->createStub(Specification::class);
        $right = $this->createStub(Specification::class);

        $left->method('isSatisfiedBy')->willReturn(false);
        $right->method('isSatisfiedBy')->willReturn(true);

        $specification = new OrNotSpecification($left, $right);

        $this->assertFalse($specification->isSatisfiedBy(new \stdClass()));
    }
}
