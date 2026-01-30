<?php

declare(strict_types=1);

namespace VasilDakov\SpecificationTests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;
use VasilDakov\Specification\AnyOfSpecification;
use VasilDakov\Specification\NoneOfSpecification;
use VasilDakov\Specification\OneOfSpecification;
use VasilDakov\Specification\UserInterface;
use VasilDakov\SpecificationTests\Assets\BoolSpecification;
use VasilDakov\SpecificationTests\Assets\Order\CancelledOrderSpecification;
use VasilDakov\SpecificationTests\Assets\Order\Order;
use VasilDakov\SpecificationTests\Assets\Order\PaidOrderSpecification;
use VasilDakov\SpecificationTests\Assets\Order\UnshippedOrderSpecification;
use VasilDakov\SpecificationTests\Assets\User\InMemoryUserRepository;
use VasilDakov\SpecificationTests\Assets\User\UserIsAdultSpecification;
use VasilDakov\SpecificationTests\Assets\User\UserIsGermanSpecification;
use VasilDakov\SpecificationTests\Assets\User\UserIsMaleSpecification;

class SpecificationTest extends TestCase
{
    #[Test]
    public function testSpecifications(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $this->assertTrue($trueSpec->isSatisfiedBy(new stdClass()));
        $this->assertFalse($falseSpec->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testNotSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $notTrueSpec  = $trueSpec->not();
        $notFalseSpec = $falseSpec->not();

        $this->assertFalse($notTrueSpec->isSatisfiedBy(new stdClass()));
        $this->assertTrue($notFalseSpec->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testAndSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $trueAndTrueSpec  = $trueSpec->and($trueSpec);
        $trueAndFalseSpec = $trueSpec->and($falseSpec);

        $this->assertTrue($trueAndTrueSpec->isSatisfiedBy(new stdClass()));
        $this->assertFalse($trueAndFalseSpec->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testAndNotSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $trueAndTrueSpec   = $trueSpec->andNot($trueSpec);
        $falseAndFalseSpec = $falseSpec->andNot($falseSpec);
        $trueAndFalseSpec  = $trueSpec->andNot($falseSpec);

        $this->assertFalse($trueAndTrueSpec->isSatisfiedBy(new stdClass()));
        $this->assertFalse($falseAndFalseSpec->isSatisfiedBy(new stdClass()));
        $this->assertTrue($trueAndFalseSpec->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testOrSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $trueOrTrueSpec  = $trueSpec->or($trueSpec);
        $trueOrFalseSpec = $trueSpec->or($falseSpec);

        $this->assertTrue($trueOrTrueSpec->isSatisfiedBy(new stdClass()));
        $this->assertTrue($trueOrFalseSpec->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testAnyOfSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $this->assertTrue((new AnyOfSpecification($trueSpec, $trueSpec, $trueSpec))->isSatisfiedBy(new stdClass()));
        $this->assertFalse((new AnyOfSpecification($trueSpec, $trueSpec, $falseSpec))->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testOneOfSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $this->assertFalse((new OneOfSpecification($falseSpec, $falseSpec, $falseSpec))->isSatisfiedBy(new stdClass()));
        $this->assertTrue((new OneOfSpecification($falseSpec, $falseSpec, $trueSpec))->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function testNoneOfSpecification(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $this->assertTrue((new NoneOfSpecification($falseSpec, $falseSpec, $falseSpec))->isSatisfiedBy(new stdClass()));
        $this->assertFalse((new NoneOfSpecification($falseSpec, $falseSpec, $trueSpec))->isSatisfiedBy(new stdClass()));
    }

    #[Test]
    public function itCombinesOrderSpecificationsUsingLogicalOperators(): void
    {
        $paid      = new PaidOrderSpecification();
        $unshipped = new UnshippedOrderSpecification();
        $cancelled = new CancelledOrderSpecification();

        self::assertTrue(
            $paid->and($unshipped)
                 ->and($unshipped)
                 ->isSatisfiedBy(new Order())
        ); // => true

        self::assertTrue(
            $paid->andNot($cancelled)
                ->and($unshipped)
                ->isSatisfiedBy(new Order())
        ); // => true

        $composite = new OneOfSpecification($paid, $unshipped, $cancelled);
        self::assertTrue($composite->isSatisfiedBy(new Order())); // => true

        self::assertTrue(
            $paid->and($unshipped)
                ->andNot($cancelled)
                ->isSatisfiedBy(new Order())
        );
    }

    #[Test]
    public function testUsageWithUser(): void
    {
        $user = self::userFactory('Bulgaria', 18, 'Male');

        $adult  = new UserIsAdultSpecification();
        $german = new UserIsGermanSpecification();
        $male   = new UserIsMaleSpecification();

        $composite = new AnyOfSpecification($adult, $german, $male);

        $this->assertFalse($composite->isSatisfiedBy($user)); // false, user is an adult male, but not German
        $this->assertTrue($adult->isSatisfiedBy($user)); // true, user is adult
        $this->assertFalse($adult->and($german)->and($male)->isSatisfiedBy($user)); // false, user is not german
    }

    #[Test]
    public function itFindsUsersSatisfyingAnySpecification(): void
    {
        $repository = new InMemoryUserRepository();

        $composite = new AnyOfSpecification(
            new UserIsAdultSpecification(),
            new UserIsGermanSpecification(),
            new UserIsMaleSpecification(),
        );

        $result = $repository->findBySpecification($composite);
        $this->assertCount(2, $result);
    }

    #[Test]
    public function itCombinesSpecificationsUsingOrNotOperator(): void
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);

        $trueOrNotTrueSpec   = $trueSpec->orNot($trueSpec);
        $falseOrNotFalseSpec = $falseSpec->orNot($falseSpec);
        $trueOrNotFalseSpec  = $trueSpec->orNot($falseSpec);
        $falseOrNotTrueSpec  = $falseSpec->orNot($trueSpec);

        $this->assertTrue($trueOrNotTrueSpec->isSatisfiedBy(new stdClass()));
        $this->assertTrue($falseOrNotFalseSpec->isSatisfiedBy(new stdClass()));
        $this->assertTrue($trueOrNotFalseSpec->isSatisfiedBy(new stdClass()));
        $this->assertFalse($falseOrNotTrueSpec->isSatisfiedBy(new stdClass()));
    }


    #[Test]
    private static function userFactory(string $country, int $age, string $gender): UserInterface
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
}
