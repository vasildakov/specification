# PHP Specification Design Pattern


[![build](https://github.com/vasildakov/specification/actions/workflows/build.yml/badge.svg?branch=main)](https://github.com/vasildakov/specification/actions/workflows/build.yml)
[![Coverage Status](https://coveralls.io/repos/github/vasildakov/specification/badge.svg?branch=main)](https://coveralls.io/github/vasildakov/specification?branch=main)
## Specification

> The central idea of Specification is to separate the statement of how to match a candidate, from the
candidate object that it is matched against. As well as its usefulness in selection, it is also valuable for
validation and for building to order.
> 
> <cite>[Eric Evans][1] and [Martin Fowler][1]</cite>

## Composite Specifications

> How do you implement a generalized specification that will give you the flexibility to express complex
requirements without implementing specialized classes for every different type of candidate? The hard
coded and parameterized specifications both use a single specification object to handle the
specification. The composite specification uses several objects arranged in the composite pattern
[Gang of Four] to do the work.
> 
> <cite>[Eric Evans][1] and [Martin Fowler][1]</cite>


## Parameterized Specification

> A Parameterized Specification allows new specifications to be built without programming, indeed at 
> run time, but you are limited as to what kind of specifications you can build by what the programmers 
> have set up.


## Usage

The Specification pattern allows you to encapsulate business rules into reusable specification objects. Each specification represents a single condition that can be evaluated against a candidate object. By chaining multiple specifications together, you can build complex validation logic without creating specialized classes for every combination of rules.

In this example, we create five independent specifications that validate different aspects of a user object:

1. **Age Specification** - Validates that the user is at least 18 years old
2. **Country Specification** - Checks if the user is from Bulgaria
3. **Gender Specification** - Verifies the user's gender
4. **Email Specification** - Ensures the email address is valid
5. **Active Account Specification** - Confirms the user's account is active

These specifications are then combined using `SpecificationChain::fromArray()`, which creates a composite specification that requires **all** individual specifications to be satisfied. When you call `isSatisfiedBy()` on the chain, it evaluates each specification in sequence. If any specification fails, the entire chain returns `false`.

This approach provides several benefits:
- **Reusability**: Each specification can be used independently or combined with others
- **Maintainability**: Business rules are isolated and easy to modify
- **Testability**: Individual specifications can be tested in isolation
- **Flexibility**: New specifications can be added without modifying existing code


## Basic Example

```php 
use VasilDakov\Specification\SpecificationChain;
use VasilDakov\Specification\SpecificationInterface;


// 1. Age specification - must be 18 or older
$ageSpec = new class implements SpecificationInterface {
    public function isSatisfiedBy(object $object): bool
    {
        return $object->getAge() >= 18;
    }
};

// 2. Country specification - must be from Bulgaria
$countrySpec = new class implements SpecificationInterface {
    public function isSatisfiedBy(object $object): bool
    {
        return $object->getCountry() === 'Bulgaria';
    }
};

// 3. Gender specification - must be male
$genderSpec = new class implements SpecificationInterface {
    public function isSatisfiedBy(object $object): bool
    {
        return $object->isMale();
    }
};

// 4. Email verification specification
$emailSpec = new class implements SpecificationInterface {
    public function isSatisfiedBy(object $object): bool
    {
        return filter_var($object->getEmail(), FILTER_VALIDATE_EMAIL) !== false;
    }
};

// 5. Active account specification
$activeSpec = new class implements SpecificationInterface {
    public function isSatisfiedBy(object $object): bool
    {
        return $object->isActive() === true;
    }
};

// Chain all specifications
$chain = SpecificationChain::fromArray([
    $ageSpec,
    $countrySpec,
    $genderSpec,
    $emailSpec,
    $activeSpec
]);

// Check if user satisfies all specifications
$user = new User(
    age: 25,
    country: 'Bulgaria',
    gender: 'Male',
    email: 'john.doe@example.bg',
    active: true
);

// All 5 specifications must be satisfied for isSatisfiedBy() to return true.
if ($chain->isSatisfiedBy($user)) {
    // User satisfies all 5 specifications
}

```



## Links
- [Specification pattern][2], Wikipedia
- [Implementing The Specification Pattern][3], Philip Brown
- [Pattern Specification][4], Romain Pierlot
- [Composite in PHP][5], SourceMaking
- [Specification design pattern in php][6], Milad
- [Specification][7], DesignPatternsPHP

[1]: https://www.martinfowler.com/apsupp/spec.pdf
[2]: https://en.wikipedia.org/wiki/Specification_pattern
[3]: https://culttt.com/2014/08/25/implementing-specification-pattern
[4]: https://blog.eleven-labs.com/fr/pattern-specification-2/
[5]: https://sourcemaking.com/design_patterns/composite/php
[6]: https://medium.com/@miladev95/specification-design-pattern-in-php-5f392dbfe76c
[7]: https://designpatternsphp.readthedocs.io/en/latest/Behavioral/Specification/README.html